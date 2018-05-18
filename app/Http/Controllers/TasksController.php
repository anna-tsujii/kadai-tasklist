<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Task;    // 追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        //ログインしていれば
        if (\Auth::check()) {
            //現在認証中のuserを取得＝$user
            $user = \Auth::user();
            //userに紐つくtaskを取得＝$task
            //$tasksは$userから引き継いだもの＋created_atもあげる＋表示は10件まで
            //descってなに？
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            //上記を$detaとして定義
            $data = [
                //=>先を呼び出してね
                'user' => $user,
                'tasks' => $tasks,
            ];
            
            $data += $this->counts($user);
            //tasksフォルダの中にあるindex.blade.phpに$dataを入れて返す
            return view('tasks.index', $data);
        
        //それ以外なら＝未ログインなら
        }else {
            //welcome.blade.phpを返す
            return view('welcome');
        }
        
        
        //$tasks = Task::all();

        //return view('tasks.index', [
        // 'tasks' => $tasks,
        //]);
    }
    
    public function show($id)
    {
        
        //URLのIDからタスクを取得
        $task = Task::find($id);
        //ログインしたユーザーのidがタスクから取得したユーザーidと一致しないなら
        if($task->user_id != (\Auth::user()->id)){
            
            //どこを返す？リダイレクト？
            return redirect('/');
       
        //それ以外なら
        }else{
        
        //showを見せる
        return view('tasks.show', [
            'task' => $task,
        ]);
        }
    }
    
    public function create()
    {
        $task = new task;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }
    
    public function store(Request $request)
    {   
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191',
        ]);
        
        
        
        $task = new task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->user_id = $request->user()->id;
        
        $task->save();

        return redirect('/');
    }
    
    public function edit($id)
    {
        //URLのIDからタスクを取得
        $task = Task::find($id);
        //ログインしたユーザーのidがタスクから取得したユーザーidと一致しないなら
        if($task->user_id != (\Auth::user()->id)){
        
            //どこを返す？リダイレクト？
            return redirect('/');
       
        //それ以外なら
        }else{
        
        //showを見せる
        return view('tasks.edit', [
            'task' => $task,
        ]);
        }

    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191',
        ]);
        
        $task = task::find($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        return redirect('/');
    }
    
    public function destroy($id)
    {
        $task = task::find($id);
        $task->delete();

        return redirect('/');
    }
    
    
    
    

}