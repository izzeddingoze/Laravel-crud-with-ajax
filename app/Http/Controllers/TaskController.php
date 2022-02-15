<?php


namespace App\Http\Controllers;

use App\Models\Task;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TaskController extends Controller
{

    public function rules()
    {
        return [
            'task_title' => 'required|max:50',
            'task_details' => 'required|max:300',
        ];
    }

    public function RulesErrors()
    {
        return [
            'required' => 'Gerekli alan',
            'max' => 'En fazla :max karakter',
        ];
    }
    public function index()
    {

        $tasks = Task::all()->sortBy("order");
        return view("tasks.list", compact('tasks'));
    }

    public function remove(Request $request)
    {

        $task = Task::find($request->task_id);



        if ($task) {

            try {
                $task->delete();
                return \response()->json(["success" => true]);
            } catch (Throwable $e) {

                return \response()->json(["success" => false, "message" => $e]);
            }
        }

        return \response()->json(["success" => false, "message" => "Silinecek görev bulunamadı"]);
    }
    public function done(Request $request)
    {

        $task = Task::find($request->task_id);



        if ($task) {

            try {
                $task->update([

                    "status" => "Done",
                ]);

                return \response()->json(["success" => true]);
            } catch (Throwable $e) {

                return \response()->json(["success" => false, "message" => $e]);
            }
        }

        return \response()->json(["success" => false, "message" => "Görev bulunamadı. Sayfayı yenileyip tekrar deneyiniz"]);
    }
    public function store(Request $request)
    {

        $rules = $this->rules();
        $rulesErrors = $this->rulesErrors();

        $validator = Validator::make($request->all(), $rules, $rulesErrors);

        if ($validator->fails())
            return \response()->json(["success" => false, "message" => $validator->errors()->all()]);

        try {
            $inserted_task_id = Task::insertGetId(
                [
                    "title" => $request->task_title,
                    "details" => $request->task_details,
                    "order" => -1,
                ]
            );
            $new_task = Task::find($inserted_task_id);
            $new_row = View("tasks.component.new-row", ['task' => $new_task])->render();

            return \response()->json(["success" => true, "new_row" => $new_row]);
        } catch (Throwable $e) {

            return \response()->json(["success" => false, "message" => $e]);
        }
    }
    public function update(Request $request)
    {

        $rules = $this->rules();
        $rulesErrors = $this->rulesErrors();

        $validator = Validator::make($request->all(), $rules, $rulesErrors);

        if ($validator->fails())
            return \response()->json(["success" => false, "message" => $validator->errors()->all()]);

        try {
            Task::find($request->task_id)->update(
                [
                    "title" => $request->task_title,
                    "details" => $request->task_details,
                ]
            );
            $new_task = Task::find($request->task_id);

          
            return \response()->json(["success" => true, "new_title" => $new_task->title, "new_details" => $new_task->details]);
        } catch (Throwable $e) {

            return \response()->json(["success" => false, "message" => $e]);
        }
    }

    public function updateOrder(Request $request)
    {
        $tasks = Task::all();


        foreach ($tasks as $task) {

            // sıralama yaparken güncelleme tarihi değişmemesi için zaman işlemlerini iptal et
            $task->timestamps = false;

            $id = $task->id;

            foreach ($request->order as $order) {
                /* Pozisyonlara göre tüm sıralama(order) bilgilerini güncelle */
                if ($order['id'] == $id) {
                    $task->update(['order' => $order['position']]);
                }
            }
        }


        return response()->json(['success' => true]);
    }
}
