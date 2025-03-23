<?php

namespace App\Services\Project;

use App\Models\Project;

class ProjectService
{

    private $total=0;
    public function __construct()
    {
        $this->total=Project::count();
    }

    public function getSumOpened()
    {
        $temp= Project::where('status_id', '11')
            ->count();
        return ($temp/$this->total)*100;
    }

    public function getSumInprogress()
    {
        $temp= Project::where('status_id', '12')
            ->count();

        return ($temp/$this->total)*100;
    }
    public function getSumBlocked()
    {
        $temp= Project::where('status_id', '13')
            ->count();

        return ($temp/$this->total)*100;
    }
    public function getSumCanceled()
    {
        $temp= Project::where('status_id', '14')
            ->count();

        return ($temp/$this->total)*100;
    }
    public function getSumCompleted()
    {
        $temp= Project::where('status_id', '15')
            ->count();

        return ($temp/$this->total)*100;
    }
}