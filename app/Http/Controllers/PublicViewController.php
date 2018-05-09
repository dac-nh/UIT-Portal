<?php

namespace App\Http\Controllers;

use App\Libraries\GeneralConstant;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Project\ProjectInterface as ProjectInterface;

/**
 * @property ProjectInterface project
 */
class PublicViewController extends Controller
{
    /**
     * PublicViewController constructor.
     * @param ProjectInterface $project
     */
    public function __construct(ProjectInterface $project)
    {
        $this->project = $project;
    }

    public function home()
    {
        $topCompanies = [
            [
                'logo' => Storage::url('company/logo/1.png'),
                'name' => 'Vietname Esports',
                'rating' => 5
            ],
            [
                'logo' => Storage::url('company/logo/2.png'),
                'name' => 'Facebook Inc',
                'rating' => 4
            ],
            [
                'logo' => Storage::url('company/logo/1.png'),
                'name' => 'Garena',
                'rating' => 4
            ]
        ];
        $topStudents = [
            [
                'avatar' => Storage::url('user/avatar/1.png'),
                'url' => '/user/1',
            ],
            [
                'avatar' => Storage::url('user/avatar/1.png'),
                'url' => '/user/1',
            ],
            [
                'avatar' => Storage::url('user/avatar/1.png'),
                'url' => '/user/1',
            ],
            [
                'avatar' => Storage::url('user/avatar/1.png'),
                'url' => '/user/1',
            ],
            [
                'avatar' => Storage::url('user/avatar/1.png'),
                'url' => '/user/1',
            ],
        ];
        $newProjects = $this->project->whereBy('status',GeneralConstant::PROJECT_HIRING)->orderBy('publish_date','desc')->take(5)->get();
                //Project::where('status',GeneralConstant::PROJECT_HIRING)->orderBy('publish_date','desc')->take(5)->get();
        return view('home')
            ->with('new_projects', $newProjects)
            ->with('top_companies',$topCompanies)
            ->with('top_students',$topStudents);
    }

    public function getProjectDetail()
    {
        return view('detail_project');
    }
}
