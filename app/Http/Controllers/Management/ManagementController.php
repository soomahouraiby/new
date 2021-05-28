<?php
namespace App\Http\Controllers\Management;

use App\Agents;
use Illuminate\Support\Facades\Validator;

use App\batch_numbers;
use App\combinations as AppCombinations;
use App\commercial_drug;
use App\Companies;
use App\Diseases;
use App\diseases_commercial;
use App\effective_material;
use App\Http\Controllers\Controller;
use App\Http\Resources\loadAjaxResource;
use App\Models\Procedures;
use App\Models\Report_detailes;
use App\Models\Sites;
use App\Models\Commercial_drugs;
use App\Models\App_users;
use App\Models\Reports;
use App\Models\Types_report;
use App\Models\User;
use App\Request\ReportsRequest;
use App\Models\Shipments;
use App\Models\Combinations;
use App\Models\Effective_materials;
use App\Shipments as AppShipments;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use PharIo\Manifest\Type;
use phpDocumentor\Reflection\Types\Nullable;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:المدير العام']);
    }

    public function get_basename($filename) {// https://stackoverflow.com/questions/29122208/php-preg-replace-string-path-given
        return preg_replace('/^.+[\\\\\\/]/', '', $filename);
    }

    //////////////// [ Show .. بلاغات وارده ]  ////////////////
    public function showReports(){
        $reports=DB::table('reports')
            ->join('types_reports', 'reports.types_report_id', '=', 'types_reports.id')
            ->join('app_users', 'reports.app_user_id', '=', 'app_users.id')
            ->select('reports.id','app_users.name as name_user','reports.report_statuses' ,'reports.state',
                'reports.date','reports.transfer_party', 'types_reports.name as type_report','reports.transfer_date')
            ->where('types_reports.name','!=','اعراض جانبية')
            ->where('types_reports.name','!=','جودة')
            ->get();
        return view('Management.showReports',compact('reports'));
    }




    //////////////// [ Details .. البلاغ ]  ////////////////
    public function report($report_no){
        $report = DB::table('reports')->select('reports.id')
            ->where('reports.id','=', $report_no)->get();  // search in given table id only
        if (!$report)
            return redirect()->back();

        $reports = DB::table('reports')
            ->join('types_reports', 'reports.types_report_id', '=', 'types_reports.id')
            ->join('app_users', 'reports.app_user_id', '=', 'app_users.id')

            ->select('reports.id','reports.amount_name','reports.phone as amount_phone','reports.opmanage_notes',
                'app_users.name as name_user','app_users.phone as phone_user','reports.commercial_name'
                ,'reports.pharmacy_title','types_reports.name as type_report','reports.date','reports.report_statuses')

            ->where('reports.id','=', $report_no)->get();

        $procedures= DB::table('procedures')
            ->select('procedures.report_id','procedures.result','procedures.procedure','procedures.date')
            ->where('report_id','=',$report_no)->get();

        return view('Management.report',compact('reports','procedures'));
    }

    //////////////// [ Details ..  بلاغ وارد ]  ////////////////
    public function detailsReport($report_no){
        $report = DB::table('reports')->select('reports.id')
            ->where('id','=', $report_no)->get();

        if (!$report)
            return redirect()->back();

        $reports = DB::table('reports')
            ->join('types_reports', 'reports.types_report_id', '=', 'types_reports.id')
            ->join('app_users', 'reports.app_user_id', '=', 'app_users.id')

            ->select('reports.id as id_report','reports.drug_picture','reports.notes_user', 'reports.date',
                'reports.drug_price','reports.commercial_name','reports.company_name','reports.agent_name',
                'reports.site_dec','reports.neig_name','reports.pharmacy_title','reports.street_name',
                'app_users.name as name_user', 'app_users.phone as phone_user', 'app_users.adjective'
                , 'app_users.age','app_users.report_count','reports.report_statuses',
                'types_reports.name as type_report')
            ->where('reports.id', '=', $report_no)->get();


        $batches = DB::table('reports')->select('reports.batch_number as batch_number')
            ->where('reports.id', '=', $report_no)->get();

        foreach ($batches as $batch) {

            $drugs = DB::table('batch_numbers')
                ->join('commercial_drugs', 'batch_numbers.commercial_id', '=', 'commercial_drugs.id')
                ->join('combinations', 'combinations.commercial_id', '=','commercial_drugs.id')
                ->join('effective_materials', 'combinations.material_id', '=', 'effective_materials.id')
                ->join('companies', 'commercial_drugs.company_id', '=', 'companies.id')
                ->join('shipments', 'batch_numbers.shipment_id', '=', 'shipments.id')

                ->select('batch_numbers.batch_num','commercial_drugs.id', 'commercial_drugs.name as drug_name',
                    'commercial_drugs.drug_form','commercial_drugs.how_use','commercial_drugs.side_effects'
                    ,'effective_materials.name as material_name','shipments.exception','batch_numbers.drug_drawn',
                    'companies.name as company_name')
                ->where('batch_numbers.batch_num','=', $batch->batch_number)->get();
        }


        return view('Management.detailsReport', compact('reports' , 'drugs'));

    }

    //////////////// [ Details ..  دواء ]  ////////////////
    public function detailsDrug($report_no){

        $batches = DB::table('reports')->select('reports.batch_number')
            ->where('reports.id', '=', $report_no)->get();

        foreach ($batches as $batch) {

            $drugs = DB::table('batch_numbers')
                ->join('commercial_drugs', 'batch_numbers.commercial_id', '=', 'commercial_drugs.id')
                ->join('combinations', 'combinations.commercial_id', '=', 'commercial_drugs.id')
                ->join('effective_materials', 'combinations.material_id', '=', 'effective_materials.id')
                ->join('companies', 'commercial_drugs.company_id', '=', 'companies.id')
                ->join('agents', 'commercial_drugs.agent_id', '=', 'agents.id')
                ->join('shipments', 'batch_numbers.shipment_id', '=', 'shipments.id')
                ->join('magnitude_drugs', 'magnitude_drugs.commercial_id', '=', 'commercial_drugs.id')
                ->join('magnitudes', 'magnitude_drugs.magnitude_id', '=', 'magnitudes.id')
                ->select('batch_numbers.batch_num', 'batch_numbers.barcode', 'batch_numbers.production_date',
                    'batch_numbers.expiry_date', 'batch_numbers.price', 'batch_numbers.quantity', 'batch_numbers.drug_drawn',
                    'commercial_drugs.id', 'commercial_drugs.name as drug_name', 'commercial_drugs.drug_form',
                    'commercial_drugs.how_use', 'commercial_drugs.side_effects', 'commercial_drugs.register_no',
                    'effective_materials.name as material_name', 'effective_materials.indications_use',
                    'companies.name as company_name', 'companies.country', 'shipments.exception',
                    'agents.name as agent_name', 'agents.phone', 'agents.email', 'agents.address',
                    'magnitudes.size', 'magnitudes.name')
                ->where('batch_numbers.batch_num', '=', $batch->batch_number)->get();
        }
        return view('Management.detailsDrug',compact('drugs'));
    }




    //////////////// [ Filter .. بلاغات وارده ]  ////////////////
    public function showNewReports(){
        $reports=DB::table('reports')
            ->join('types_reports', 'reports.types_report_id', '=', 'types_reports.id')
            ->join('app_users', 'reports.app_user_id', '=', 'app_users.id')
            ->select('reports.id','app_users.name as name_user','reports.report_statuses' ,'reports.state',
                'reports.date','reports.transfer_party', 'types_reports.name as type_report','reports.transfer_date')
            ->where('transfer_date','=',null)
            ->where('types_reports.name','!=','اعراض جانبية')
            ->where('types_reports.name','!=','جودة')
            ->get();
        return view('Management.showReports',compact('reports'));
    }

    //////////////// [ Filter .. بلاغات محول للمتابعة ]  ////////////////
    public function showTransferReports(){
        $reports=DB::table('reports')
            ->join('types_reports', 'reports.types_report_id', '=', 'types_reports.id')
            ->join('app_users', 'reports.app_user_id', '=', 'app_users.id')
            ->select('reports.id','app_users.name as name_user','reports.report_statuses' ,'reports.state',
                'reports.date','reports.transfer_party', 'types_reports.name as type_report','reports.transfer_date')
            ->where('report_statuses','=','محول للمتابعة')
            ->where('types_reports.name','!=','اعراض جانبية')
            ->where('types_reports.name','!=','جودة')
            ->get();
        return view('Management.showReports',compact('reports'));
    }

    //////////////// [ Filter .. بلاغات قيد المتابعة ]  ////////////////
    public function showFollowingReports(){
        $reports=DB::table('reports')
            ->join('types_reports', 'reports.types_report_id', '=', 'types_reports.id')
            ->join('app_users', 'reports.app_user_id', '=', 'app_users.id')
            ->select('reports.id','app_users.name as name_user','reports.report_statuses' ,'reports.state',
                'reports.date','reports.transfer_party', 'types_reports.name as type_report','reports.transfer_date')
            ->where('report_statuses','=','قيد المتابعة')
            ->where('types_reports.name','!=','اعراض جانبية')
            ->where('types_reports.name','!=','جودة')
            ->get();

        return view('Management.showReports',compact('reports'));
    }

    //////////////// [ Filter .. بلاغات تمت المتابعة ]  ////////////////
    public function showFollowDoneReports(){
        $reports=DB::table('reports')
            ->join('types_reports', 'reports.types_report_id', '=', 'types_reports.id')
            ->join('app_users', 'reports.app_user_id', '=', 'app_users.id')
            ->select('reports.id','app_users.name as name_user','reports.report_statuses' ,'reports.state',
                'reports.date','reports.transfer_party', 'types_reports.name as type_report','reports.transfer_date')
            ->where('report_statuses','=','تمت المتابعة')
            ->where('types_reports.name','!=','اعراض جانبية')
            ->where('types_reports.name','!=','جودة')
            ->get();
        return view('Management.showReports',compact('reports'));
    }

    //////////////// [ Filter .. بلاغات تم الانهاء ]  ////////////////
    public function showDoneReports(){
        $reports=DB::table('reports')
            ->join('types_reports', 'reports.types_report_id', '=', 'types_reports.id')
            ->join('app_users', 'reports.app_user_id', '=', 'app_users.id')
            ->select('reports.id','app_users.name as name_user','reports.report_statuses' ,'reports.state',
                'reports.date','reports.transfer_party', 'types_reports.name as type_report','reports.transfer_date')
            ->where('report_statuses','=','تم الانهاء')
            ->where('types_reports.name','!=','اعراض جانبية')
            ->where('types_reports.name','!=','جودة')
            ->get();
        return view('Management.showReports',compact('reports'));
    }


    public function load_ajax(Request $data, $table){
        if(Schema::hasTable($table)){
            return  response()->json(loadAjaxResource::collection(DB::table($table)->where('name', 'like' ,"%".  $data->term ."%")->get())) ;
        }
        return  response()->json(['']);

    }

    public function batch_numbers(Request $types){


        if(isset($types->search) && !empty($types->search)){
            $batch_numbers = batch_numbers::where('batch_num', 'like' ,"%".  $types->search ."%")->orderBy('id', 'DESC')->get();
        }else {
            $batch_numbers = batch_numbers::orderBy('id', 'DESC')->get();
        }

        $cont = 1;
        return view('Management.batch_numbers',compact('batch_numbers', 'types', 'cont'));
    }
    public function batch_numbers_add(){
        return view('Management.batch_numbers_add');
    }

    public function batch_numbers_edite( $id){
        $batch_number = batch_numbers::where('id', $id)->first();
        $commercial_drug = NULL;
        if( (old('commercial') != NULL && is_numeric(old('commercial')))){
            $commercial_drug = commercial_drug::where('id', old('commercial'))->first();
        }

        return view('Management.batch_numbers_edite',compact('batch_number', 'id', 'commercial_drug'));
    }

    public function batch_numbers_update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'batch_num' =>  'required|numeric|unique:batch_numbers,batch_num,'. $id. ',id' ,
            'barcode' => 'required|numeric|unique:batch_numbers,barcode,'. $id. ',id',
            'production_date'    => 'required|date',
            'expiry_date'    => 'required|date',
            'quantity'     => 'required|numeric',
            'price'     => 'required|numeric',
            'drug_drawn'     => 'required|boolean',
            'commercial'     => 'required|exists:commercial_drugs,id',
            'shipment_type'     => 'required|exists:shipments,expception',
        ]);


        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all);

        }

        $batch_number  =  batch_numbers::where( 'id',  $id)->first();
        $batch_number->batch_num = $request->input('batch_num');
        $batch_number->barcode  = $request->input('barcode');
        $batch_number->shipment_id  = AppShipments::where('expception', $request->input('shipment_type'))->first()->id;
        $batch_number->commercial_id  = $request->input('commercial');
        $batch_number->production_date = $request->input('production_date');
        $batch_number->expiry_date = $request->input('expiry_date');
        $batch_number->quantity = $request->input('quantity');
        $batch_number->price = $request->input('price');
        $batch_number->drug_drawn = $request->input('drug_drawn');
        $batch_number->save();
        return Redirect::route('batch_numbers')->with('success', ['message'=>'تم تعديل دفعة  بنجاح ', 'id'=>  $batch_number->id]);


    }
    public function batch_numbers_insert(Request $request){


        $validator = Validator::make($request->all(), [
            'batch_num' =>  'required|numeric|unique:batch_numbers,batch_num',
            'barcode' => 'required|numeric|unique:batch_numbers,barcode',
            'production_date'    => 'required|date',
            'expiry_date'    => 'required|date',
            'quantity'     => 'required|numeric',
            'price'     => 'required|numeric',
            'drug_drawn'     => 'required|boolean',
            'commercial'     => 'required|exists:commercial_drugs,id',
            'shipment_type'     => 'required|exists:shipments,expception',
        ]);


        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);

        }

        $batch_number = new  batch_numbers();
        $batch_number->batch_num = $request->input('batch_num');
        $batch_number->barcode  = $request->input('barcode');
        $batch_number->shipment_id  = AppShipments::where('expception', $request->input('shipment_type'))->first()->id;
        $batch_number->commercial_id  = $request->input('commercial');
        $batch_number->production_date = $request->input('production_date');
        $batch_number->expiry_date = $request->input('expiry_date');
        $batch_number->quantity = $request->input('quantity');
        $batch_number->price = $request->input('price');
        $batch_number->drug_drawn = $request->input('drug_drawn');
        $batch_number->save();
        return Redirect::route('batch_numbers')->with('success', ['message'=>'تم اضافة دفعة  بنجاح ', 'id'=>  $batch_number->id]);

    }
    public function batch_numbers_delete(Request $id){

        batch_numbers::destroy( $id->id);


        return Redirect::route('batch_numbers')->with('message', 'تم الحدف بنجاح ');

    }


// drugs

public function all_companies(Request $types){
   if(isset($types->search) && !empty($types->search)){

        $companies = Companies::where('name', 'like' ,"%".  $types->search ."%")->orderBy('id', 'DESC')->get();
    }else {
        $companies = Companies::orderBy('id', 'DESC')->get();
    }

    $cont = 1;
    return view('Management.companies',compact('companies', 'types', 'cont'));
}
public function companies_delete(Request $id){
    Companies::destroy( $id->id);
    return Redirect::route('all_companies')->with('message', 'تم الحدف بنجاح ');
}

public function companies_edite( $id){
    $companie = Companies::where('id', $id)->first();
    return view('Management.companies_edite',compact('companie', 'id'));
}

public function companies_update(Request $request, $id){

    $validator = Validator::make($request->all(), [
        'name' =>  'required|string|unique:companies,name,'. $id. ',id' ,
        'country' => 'required|string',
    ]);


    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator)->withInput($request->all);

    }

    $companie  =  Companies::where( 'id',  $id)->first();
    $companie->name = $request->input('name');
    $companie->country  = $request->input('country');

    $companie->save();
    return Redirect::route('all_companies')->with('success', ['message'=>'تم تعديل الدواء بنجاح ', 'id'=>  $companie->id]);


}

public function companies_add(){
    return view('Management.companies_add');

}
public function companies_insert(Request $request){


    $validator = Validator::make($request->all(), [
        'name' =>  'required|string|unique:companies,name' ,
        'country' => 'required|string',
    ]);


    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator);

    }

    $companie = new  Companies();
    $companie->name = $request->input('name');
    $companie->country  = $request->input('country');
    $companie->save();
    return Redirect::route('all_companies')->with('success', ['message'=>'تم اضافة الدواء بنجاح ', 'id'=>  $companie->id]);

}


public function all_agents(Request $types){
    if(isset($types->search) && !empty($types->search)){

         $agents = Agents::where('name', 'like' ,"%".  $types->search ."%")->orderBy('id', 'DESC')->get();
     }else {
         $agents = Agents::orderBy('id', 'DESC')->get();
     }

     $cont = 1;
     return view('Management.agents',compact('agents', 'types', 'cont'));
 }

 public function agents_add(){
    return view('Management.agents_add');

}

public function agents_insert(Request $request){


    $validator = Validator::make($request->all(), [
        'name' =>  'required|string|unique:agents,name',
        'email' => 'required|email|unique:agents,email',
        'phone'    => 'numeric'
    ]);


    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator);

    }

    $agent = new  Agents();
    $agent->name = $request->input('name');
    $agent->email  = $request->input('email');
    $agent->phone  = $request->input('phone');
    $agent->address  = $request->input('address');

    $agent->save();
    return Redirect::route('all_agents')->with('success', ['message'=>'تم اضافة الوكيل  بنجاح ', 'id'=>  $agent->id]);

}

public function agents_delete(Request $id){
    Agents::destroy( $id->id);
    return Redirect::route('all_agents')->with('message', 'تم الحدف بنجاح ');
}

public function agents_edite( $id){
    $agent = Agents::where('id', $id)->first();
    return view('Management.agents_edite',compact('agent', 'id'));
}


public function agents_update(Request $request, $id){


    $validator = Validator::make($request->all(), [
        'name' =>  'required|string|unique:agents,name,'. $id. ',id' ,
        'email' => 'required|email|unique:agents,email,'. $id. ',id' ,
        'phone'    => 'numeric'
    ]);


    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator)->withInput($request->all);

    }

    $agent  =  Agents::where( 'id',  $id)->first();
    $agent->name = $request->input('name');
    $agent->email  = $request->input('email');
    $agent->phone  = $request->input('phone');
    $agent->address  = $request->input('address');

    $agent->save();
    return Redirect::route('all_agents')->with('success', ['message'=>'تم تعديل  الوكيل  بنجاح ', 'id'=>  $agent->id]);

}



public function all_effective_materials(Request $types){
    if(isset($types->search) && !empty($types->search)){

         $effective_materials = effective_material::where('name', 'like' ,"%".  $types->search ."%")::orderBy('id', 'DESC')->get();
     }else {
         $effective_materials = effective_material::orderBy('id', 'DESC')->get();
     }

     $cont = 1;
     return view('Management.effective_materials',compact('effective_materials', 'types', 'cont'));
 }


 public function effective_materials_add(){
    return view('Management.effective_materials_add');

}

public function effective_materials_insert(Request $request){


    $validator = Validator::make($request->all(), [
        'name' =>  'required|string|unique:effective_materials,name' ,
        'indications_use' => 'required|string',
    ]);


    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator);

    }

    $effective_material = new  effective_material();
    $effective_material->name = $request->input('name');
    $effective_material->indications_use  = $request->input('indications_use');
    $effective_material->save();
    return Redirect::route('all_effective_materials')->with('success', ['message'=>'تم اضافة
    المادة بنجاح ', 'id'=>  $effective_material->id]);

}

public function effective_materials_delete(Request $id){
    effective_material::destroy( $id->id);
    return Redirect::route('all_effective_materials')->with('message', 'تم الحدف بنجاح ');
}

public function effective_materials_edite($id){
    $effective_material = effective_material::where('id', $id)->first();
    return view('Management.effective_materials_edite',compact('effective_material', 'id'));
}


public function effective_materials_update(Request $request, $id){


    $validator = Validator::make($request->all(), [
        'name' =>  'required|string|unique:effective_materials,name,'. $id. ',id' ,
        'indications_use' => 'required|string' ,
    ]);


    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator)->withInput($request->all);

    }

    $effective_material  =  effective_material::where( 'id',  $id)->first();
    $effective_material->name = $request->input('name');
    $effective_material->indications_use  = $request->input('indications_use');

    $effective_material->save();
    return Redirect::route('all_effective_materials')->with('success', ['message'=>'تم تعديل  الوكيل  بنجاح ', 'id'=>  $effective_material->id]);

}


public function all_drugs(Request $types){

    $list_drug_form =   config('listdrugform');
    if(isset($types->search) && !empty($types->search)){

        $commercial_drugs = commercial_drug::where('name', 'like' ,"%".  $types->search ."%")->orderBy('id', 'DESC')->get();
    }else {
        $commercial_drugs = commercial_drug::orderBy('id', 'DESC')->get();
    }
$cont = 1;

    return view('Management.all_drugs',compact('commercial_drugs', 'types', 'list_drug_form', 'cont'));
}

public function drugs_delete( $id){
    $file = storage_path('app/public/images/drugs/'.  commercial_drug::where( 'id',  $id)->first()->photo);
    if(file_exists($file)) unlink($file);


    commercial_drug::destroy( $id);
    return Redirect::route('all_drugs')->with('message', 'تم الحدف بنجاح ');

}




public function drugs_add(){
    $list_drug_form =   config('listdrugform');

    return view('Management.drugs_add', compact('list_drug_form') );
}

public function drugs_insert(Request $request){


    $validator = Validator::make($request->all(), [
        'name' =>  'required|string' ,
        'register_no' => 'required|numeric|unique:commercial_drugs,register_no',
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'how_use' => 'required|string',
        'side_effects' => 'required|string',
        'drug_form'    => 'required|in:' .  implode(',',array_keys(config('listdrugform'))),
        'prevents_use' => 'required|string',
        'company_id'     => 'required|numeric|exists:companies,id',
        'agent_id'     => 'required|numeric|exists:companies,id',
        'material_id.*' => 'required|numeric|exists:effective_materials,id',
        'diseases_id.*' => 'required|numeric|exists:diseases,id'
        ]);


    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator);

    }

         $path = $request->file('photo')->store('images/drugs', 'public');

        $commercial_drug = new commercial_drug();
        $commercial_drug->name =  $request->input('name');
        $commercial_drug->register_no =  $request->input('register_no');
        $commercial_drug->photo =  $this->get_basename( $path);
        $commercial_drug->how_use =  $request->input('how_use');
        $commercial_drug->side_effects =  $request->input('side_effects');
        $commercial_drug->drug_form =  $request->input('drug_form');
        $commercial_drug->prevents_use =  $request->input('prevents_use');
        $commercial_drug->company_id =  $request->input('company_id');
        $commercial_drug->agent_id =  $request->input('agent_id');
        $commercial_drug->drug_entrance =  '';/// @@@@@@@@@@@@@@@@@@@@@@@@@@@@drug_entrance

    $commercial_drug->save();

    foreach($request->input('material_id') as $material_id){
        $combination = new AppCombinations();
        $combination->material_id = $material_id;
        $combination->commercial_id = $commercial_drug->id;
        $combination->save();
    }
    foreach($request->input('diseases_id') as $diseases_id){
        $disease = new diseases_commercial();
        $disease->diseases_id = $diseases_id;
        $disease->commercial_id = $commercial_drug->id;
        $disease->save();
    }


    return Redirect::route('all_drugs')->with('success', ['message'=>'تم اضافة
    الدواء  بنجاح ', 'id'=>  $commercial_drug->id]);

}



public function drugs_edite( $id){
    $drug = commercial_drug::where('id', $id)->first();
    $list_drug_form =   config('listdrugform');
    $companie = NULL;
    if( (old('company_id') != NULL && is_numeric(old('company_id')))){
        $companie = Companies::where('id', old('company_id'))->first();
    }

    $agent = NULL;
    if( (old('agent_id') != NULL && is_numeric(old('agent_id')))){
        $agent = Agents::where('id', old('agent_id'))->first();
    }
    $diseases = NULL;
    if( (old('diseases_id') != NULL && is_numeric(old('diseases_id')))){
        $diseases = Diseases::where('id', old('diseases_id'))->get();
    }

    $material = NULL;
    if( (old('material_id') != NULL && is_numeric(old('material_id')))){
        $material = effective_material::where('id', old('material_id'))->get();
    }


    return view('Management.drugs_edite',compact('drug', 'id', 'list_drug_form', 'companie', 'agent', 'diseases','material'));
}

public function drugs_update(Request $request, $id){


    $validator = Validator::make($request->all(), [
        'name' =>  'required|string' ,
        'register_no' =>  'required|numeric|unique:commercial_drugs,register_no,'. $id. ',id' ,
        'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'how_use' => 'required|string',
        'side_effects' => 'required|string',
        'drug_form'    => 'required|in:' .  implode(',',array_keys(config('listdrugform'))),
        'prevents_use' => 'required|string',
        'company_id'     => 'required|numeric|exists:companies,id',
        'agent_id'     => 'required|numeric|exists:companies,id',
        'material_id.*' => 'required|numeric|exists:effective_materials,id',
        'diseases_id.*' => 'required|numeric|exists:diseases,id'
        ]);


    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator);

    }




        $commercial_drug =  commercial_drug::where( 'id',  $id)->first();
        $commercial_drug->name =  $request->input('name');
        $commercial_drug->register_no =  $request->input('register_no');
        if($request->file('photo') != NULL){
            $path = $request->file('photo')->store('images/drugs', 'public');
            $file = storage_path('app/public/images/drugs/'.  $commercial_drug->photo);
            if(file_exists($file)) @unlink($file);
            $commercial_drug->photo =  $this->get_basename( $path);
       }
        $commercial_drug->how_use =  $request->input('how_use');
        $commercial_drug->side_effects =  $request->input('side_effects');
        $commercial_drug->drug_form =  $request->input('drug_form');
        $commercial_drug->prevents_use =  $request->input('prevents_use');
        $commercial_drug->company_id =  $request->input('company_id');
        $commercial_drug->agent_id =  $request->input('agent_id');
        $commercial_drug->drug_entrance =  '';/// @@@@@@@@@@@@@@@@@@@@@@@@@@@@drug_entrance

    $commercial_drug->save();


    if(is_array($request->input('material_id') )){
        AppCombinations::where('commercial_id', $id)->delete();
        foreach($request->input('material_id') as $material_id){
            $combination = new AppCombinations();
            $combination->material_id = $material_id;
            $combination->commercial_id = $id;
            $combination->save();
        }
    }

    if(is_array($request->input('diseases_id') )){
        diseases_commercial::where('commercial_id', $id)->delete();
    foreach($request->input('diseases_id') as $diseases_id){
        $disease = new diseases_commercial();
        $disease->diseases_id = $diseases_id;
        $disease->commercial_id = $id;
        $disease->save();
    }
}


    return Redirect::route('all_drugs')->with('success', ['message'=>'تم التعديل بنجاح
    الدواء  بنجاح ', 'id'=>  $commercial_drug->id]);


}
}
