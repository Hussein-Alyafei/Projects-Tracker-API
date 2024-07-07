<?php

namespace App\Http\Filters;

class ProjectFilter extends QueryFilter
{
    protected $sortable = [
        'title',
        'status',
        'year',
        'term',
        'deadline',
        'gitHub_url',
        'documentation',
        'description',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at'
    ];

    public function title($value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('title', 'like', $likeStr);
    }

    public function status($value)
    {
        return $this->builder->whereIn('status', explode(',', $value));
    }

    public function year($value)
    {
        return $this->builder->whereIn('year', explode(',', $value));
    }

    public function term($value)
    {
        return $this->builder->whereIn('term', explode(',', $value));
    }

    public function deadline($value)
    {
        return $this->builder->whereDate('deadline', $value);
    }

    public function gitHub_url($value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('gitHub_url', 'like', $likeStr);
    }

    public function documentation($value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('documentation', 'like', $likeStr);
    }

    public function description($value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('description', 'like', $likeStr);
    }

    public function createdAt($value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }

    public function updatedAt($value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        return $this->builder->whereDate('updated_at', $value);
    }
}

    /*
    * Example URL to test filtering and sorting functionality:
    * Filters projects by status 'in-progress' and GitHub URL containing 'Kathlyn-Heller',
    * sorts projects by title in descending order, and includes all details.
    * URL: http://projects-tracker.test/api/projects?filter[status]=in-progress&filter[github_url]=*Kathlyn-Heller*&sort=-title&include=details
    *
    * Note: Ensure your database fields accurately reflect these conditions or your specific conditions.
    */




