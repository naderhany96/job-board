<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Http\Request;

class JobFilterService
{
    public function filter(Request $request)
    {
        $query = Job::query();

        // Apply different filtering strategies
        $this->applyBasicFilters($query, $request);
        $this->applyRelationshipFilters($query, $request);
        $this->applyAttributeFilters($query, $request);

        return $query;
    }

    private function applyBasicFilters($query, Request $request)
    {
        $filters = $request->query('filter', []);

        if (!empty($filters)) {
            $query->where(function ($q) use ($filters) {
                foreach ($filters as $boolean => $conditions) {
                    if (!in_array($boolean, ['AND', 'OR'])) {
                        continue; // Skip invalid keys
                    }

                    $q->{$boolean === 'AND' ? 'where' : 'orWhere'}(function ($nestedQuery) use ($conditions, $boolean) {
                        foreach ($conditions as $field => $value) {
                            if (in_array($field, ['title', 'description', 'company_name'])) {
                                $nestedQuery->{$boolean === 'AND' ? 'where' : 'orWhere'}($field, 'LIKE', "%{$value}%");
                            } elseif (in_array($field, ['salary_min', 'salary_max'])) {
                                if (preg_match('/(>=|<=|>|<|!=|=)(\d+)/', $value, $matches)) {
                                    $operator = $matches[1];
                                    $val = $matches[2];
                                    $nestedQuery->{$boolean === 'AND' ? 'where' : 'orWhere'}($field, $operator, $val);
                                }
                            } elseif (in_array($field, ['is_remote', 'status', 'job_type'])) {
                                $nestedQuery->{$boolean === 'AND' ? 'where' : 'orWhere'}($field, $value);
                            } elseif (in_array($field, ['published_at', 'created_at'])) {
                                if (preg_match('/(>=|<=|>|<|!=|=)([0-9-]+)/', $value, $matches)) {
                                    $operator = $matches[1];
                                    $date = $matches[2];
                                    $nestedQuery->{$boolean === 'AND' ? 'whereDate' : 'orWhereDate'}($field, $operator, $date);
                                }
                            }
                        }
                    });
                }
            });
        }
    }



    private function applyRelationshipFilters($query, Request $request)
    {
        $relationships = [
            'languages' => 'languages.name',
            'locations' => 'locations.city', 
            'categories' => 'categories.name',
        ];

        foreach ($relationships as $filterKey => $column) {
            foreach ($request->query() as $param => $value) {
                if (strpos($param, $filterKey) === 0) {
                    $operator = strtoupper(str_replace($filterKey . "_", "", $param));
                    $this->applyFilterOperation($query, $filterKey, $column, $operator, $value);
                }
            }
        }
    }

    private function applyFilterOperation($query, $relation, $column, $operator, $value)
    {
        $values = explode(',', $value);

        switch ($operator) {
            case '=': 
            case 'HAS_ANY': // Job has any of the specified values
                $query->whereHas($relation, function ($q) use ($column, $values) {
                    $q->whereIn($column, $values);
                });
                break;

            case 'IS_ANY': // Matches any relationship values (OR condition)
                $query->where(function ($q) use ($relation, $column, $values) {
                    foreach ($values as $val) {
                        $q->orWhereHas($relation, function ($q2) use ($column, $val) {
                            $q2->where($column, $val);
                        });
                    }
                });
                break;

            case 'EXISTS': // Checks if relationship exists (1 = exists, 0 = does not exist)
                if ($value == '1') {
                    $query->whereHas($relation);
                } elseif ($value == '0') {
                    $query->whereDoesntHave($relation);
                }
                break;
        }
    }

    private function applyAttributeFilters($query, Request $request)
    {
        if ($request->has('attribute')) {
            foreach ($request->query('attribute') as $attr => $condition) {
                if (preg_match('/(>=|<=|>|<|!=|=)(.+)/', $condition, $matches)) {
                    $operator = $matches[1];
                    $value = $matches[2];

                    $query->whereHas('attributeValues', function ($q) use ($attr, $operator, $value) {
                        $q->where('attribute_id', $attr)
                            ->where('value', $operator, $value);
                    });
                }
            }
        }
    }

    private function parseFilterString($filterString)
    {
      
        if (is_array($filterString)) {
            return $filterString;
        }

       
        $decoded = json_decode($filterString, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function applyLogicalFilters($query, $filterString)
    {
        $filterArray = $this->parseFilterString($filterString);
        $this->applyFilterGroup($query, $filterArray);
    }

    private function applyFilterGroup($query, $filterGroup, $boolean = 'AND')
    {
        $query->where(function ($q) use ($filterGroup, $boolean) {
            foreach ($filterGroup as $key => $condition) {
                if ($key === 'AND' || $key === 'OR') {
                    $q->{$key === 'AND' ? 'where' : 'orWhere'}(function ($nestedQuery) use ($condition, $key) {
                        $this->applyFilterGroup($nestedQuery, $condition, $key);
                    });
                } else {
                    foreach ($condition as $field => $value) {
                        $operator = '=';
                        if (preg_match('/(<=|>=|!=|>|<)/', $value, $matches)) {
                            $operator = $matches[1];
                            $value = str_replace($operator, '', $value);
                        }
                        $q->{$boolean === 'AND' ? 'where' : 'orWhere'}($field, $operator, $value);
                    }
                }
            }
        });
    }
}
