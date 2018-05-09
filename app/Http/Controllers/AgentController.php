<?php

namespace App\Http\Controllers;

use App\Libraries\GeneralConstant;
use App\Models\Company;
use App\Models\StudentProfile;
use Hash;
use Illuminate\Http\Request;
use App\Models\UserApplyProject;
use App\Models\User;
use App\Models\University;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Log;
use App\Repositories\Project\ProjectInterface as ProjectInterface;

//Check if agent or not
class AgentController extends Controller
{
    public function __construct(ProjectInterface $project)
    {
        $this->project = $project;
        return $this->middleware('isAgent');
    }

    public function exportStudentList(Request $request)
    {
        $file_name = "student_list.csv";
        $students = UserApplyProject::all();
        $count = count($students);
        $myfile = fopen("$file_name", "w");
        fwrite($myfile, pack("CCC", 0xef, 0xbb, 0xbf));
        for ($i = 0; $i < $count; $i++) {
            $string = $students[$i]["id"] . "," .
                $students[$i]["full_name"] . "," .
                $students[$i]["birthday"] . "," .
                $students[$i]["is_female"] . "," .
                $students[$i]["university_name"] . "," .
                $students[$i]["faculty_name"] . "," .
                $students[$i]["major_name"] . "," .
                $students[$i]["academic_year"] . "," .
                $students[$i]["gpa"] . "," .
                $students[$i]["intro"] . "," .
                $students[$i]["address_id"] . ",'" .
                $students[$i]["phone"] . "," .
                $students[$i]["skype_id"];
            fwrite($myfile, $string . "\r\n");
        }
        fclose($myfile);
        header("Content-Type: application/download");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Length: " . filesize("$file_name"));
        $fp = fopen("$file_name", "r");
        fpassthru($fp);
        fclose($fp);
        unlink("$file_name");
    }

    // TODO: real cv_list data
    public function getUniManagement()
    {
        $agent = Auth::user();
        $agent->university_name = "DHCNTT";
        $uni_logo = Storage::url('university/logo/' . $agent->university_id . '.png');
        $cv_list = [
            [
                'id' => '1',
                'name' => 'CV 1',
                'student_name' => 'Nguyễn Văn A',
                'review_date' => '2016-10-3 21:00:00'
            ],
            [
                'id' => '2',
                'name' => 'CV 2',
                'student_name' => 'Nguyễn Văn B',
                'review_date' => '2016-11-5 12:00:00'
            ],
            [
                'id' => '3',
                'name' => 'CV 3',
                'student_name' => 'Nguyễn Văn C',
                'review_date' => '2016-10-3 21:00:00'
            ],
            [
                'id' => '4',
                'name' => 'CV 4',
                'student_name' => 'Nguyễn Văn D',
                'review_date' => '2016-11-5 12:00:00'
            ],
        ];
        return view('agent.manage_uni')
            ->with('agent', $agent)
            ->with('uni_logo', $uni_logo)
            ->with('cv_list', $cv_list);

    }

    // TODO: real cv_list data
    public function getLecturerManagement()
    {
        $lecture = Auth::user();
        $uni_logo = Storage::url('user/avatar/' . $lecture->id . '.png');
        $cv_list = [
            [
                'id' => '1',
                'name' => 'CV 1',
                'student_name' => 'Nguyễn Văn A',
                'review_date' => '2016-10-3 21:00:00'
            ],
            [
                'id' => '2',
                'name' => 'CV 2',
                'student_name' => 'Nguyễn Văn B',
                'review_date' => '2016-11-5 12:00:00'
            ],
            [
                'id' => '3',
                'name' => 'CV 3',
                'student_name' => 'Nguyễn Văn C',
                'review_date' => '2016-10-3 21:00:00'
            ],
            [
                'id' => '4',
                'name' => 'CV 4',
                'student_name' => 'Nguyễn Văn D',
                'review_date' => '2016-11-5 12:00:00'
            ],
        ];
        return view('manage_lecturer')
            ->with('agent', $lecture)
            ->with('uni_logo', $uni_logo)
            ->with('cv_list', $cv_list);

    }

    public function getAppliedStudentView()
    {
        return view('applied_student_list');
    }

    public function getAppliedStudentListAPI(Request $request)
    {
        $studentName = $request->get('student_name');
        $companyId = $request->get('company_id');
        $result = $request->get('result');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $query = UserApplyProject::with('studentprofile','project.company');
        $universityId = 1;
        $query = $query->whereHas('studentprofile', function ($q) use ($universityId){
            $q->where('university_id',$universityId);
        });
        if ($studentName != "") {
            $query = $query->where('student_name', 'LIKE', "%$studentName%");
        }
        if ($companyId != "") {
            $query = $query->whereHas('project', function ($q) {
                $q->where('id', '=', Input::get('company_id'));

            });
        }
        if ($result != "") {
            $query = $query->where('result', $result);
        }
        if ($fromDate != "") {
            $query = $query->where('created_at', '>=', $fromDate);
        }
        if ($toDate != "") {
            $query = $query->where('created_at', '<=', $toDate);
        }
        return $query->get();
    }

    public function exportAppliedStudentListAPI(Request $request)
    {
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $query = UserApplyProject::with('project.company');
        if ($request->has('student_name') && $request->get('student_name') != "") {
            $studentName = $request->get('student_name');
            $query = $query->where('student_name', 'LIKE', "%$studentName%");
        }

        if ($request->has('company_id') && $request->get('company_id') != "" && $request->get('company_id') != "?") {
            $query = $query->whereHas('project', function ($q) {
                $q->where('id', '=', Input::get('company_id'));

            });
        }
        if ($request->has('result') && $request->get('result') != "" && $request->get('result') != "?") {
            $result = $request->get('result');
            $query = $query->where('result', $result);
        }
        if ($fromDate != "") {
            $query = $query->where('created_at', '>=', $fromDate);
        }
        if ($toDate != "") {
            $query = $query->where('created_at', '<=', $toDate);
        }
        $fileName = "applied_student_list.csv";
        $students = $query->get();

        $count = count($students);
        $myfile = fopen("$fileName", "w");
        fwrite($myfile, pack("CCC", 0xef, 0xbb, 0xbf));
        for ($i = 0; $i < $count; $i++) {
            $string = $students[$i]["id"] . "," .
                $students[$i]["student_name"] . "," .
                $students[$i]["project"]["name"] . "," .
                $students[$i]["project"]["company"]["name"] . "," .
                $students[$i]["created_at"] . ",";
            switch ($students[$i]["result"]) {
                case 0:
                    $string .= "Đang chờ,";
                    break;
                case 1:
                    $string .= "Đậu,";
                    break;
                case 2:
                    $string .= "Rớt,";
                    break;
            }

            fwrite($myfile, $string . "\r\n");
        }
        fclose($myfile);
        header("Content-Type: application/download");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Length: " . filesize("$fileName"));
        $fp = fopen("$fileName", "r");
        fpassthru($fp);
        fclose($fp);
        unlink("$fileName");
    }

    public function getCreateLecture()
    {
        $universities = University::all();
        return view('create_lecture_account')->with('universities', $universities);
    }

    //TODO : Need to confirm before with Angular
    public function createLecture(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:user|max:255',
            'name' => 'required|max:120',
            'university_id' => 'required',
            'faculty' => 'required',
            'file' => 'file|image'
        ]);
        $password =  idate("U");
        $email = $request->get('email');
        $university_id = $request->get('univerisity_id');
        $faculty = $request->get('faculty');
        $name = $request->get('name');
        // 11-22-2016: Dac: change new way to create User
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->role_id = GeneralConstant::LECTURER_ROLE;
        $user->university_id = $university_id;
        Log::info('[AGENT CONTROLLER] Before send mail');

        if (!EmailController::sendEmailSignUp($request, $user, GeneralConstant::LECTURER_ROLE)){
            Log::info('[AGENT CONTROLLER] CANNOT SEND MAIL');
        };
        // $user->save();
        $file = $request->file('file');
        Storage::put('/public/user/avatar/' . User::max('id') . '.png', file_get_contents($file->getRealPath()));
        return redirect('/manage-uni');
    }

    public function getCreateCompanyAgent()
    {
        return view('create_company_account');
    }

    //TODO : Need to confirm before with Angular + Lack of address data
    public function createCompanyAgent(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:user|max:255',
            'name' => 'required|max:120',
            'password' => 'required|max:255',
            'confirm_password' => 'required|max:255|same:password',
            'url' => 'required|max:255|unique:companies',
            'file' => 'required|file|image'
        ]);
//        $password = $request->get('password');
        $password = Hash::make(idate("U"));
        $email = $request->get('email');
        $website = $request->get('website');
        $name = $request->get('name');

        Company::create([
            'name' => $name,
            'url' => $website,
            'address_id' => '3'
        ]);
        $new_company_id = Company::max('id');
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'is_active' => '1',
            'is_superuser' => '0',
            'rating' => '0',
            'role_id' => '3',
            'company_id' => $new_company_id
        ]);
        // 11-15-2016: Dac: Send email to company user
        EmailController::sendEmailSignUp($request, $user, GeneralConstant::COMPANY_ROLE);

        $file = $request->file('file');
        Storage::put('/public/company/logo/' . $new_company_id . '.png', file_get_contents($file->getRealPath()));
        return redirect('/manage-uni');
    }

    public function getManageProjectView(){
        return view('agent.manage_project');
    }
    public function getCreateProjectView(){
        return view('agent.create_project');
    }
    public function createProjectAPI(Request $request){
        $this->project->createProject($request->all());
        return redirect(Route('getManageProjectView'));
    }
}
