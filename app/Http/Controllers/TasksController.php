<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task; 

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (\Auth::check()) { 
            $user = \Auth::user();
            $tasks =$user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            
            return view('tasks.index', [
                'tasks' => $tasks,
                
            ]);
        }
        
        return view('welcome');
    }
        
        

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function create()
    {
        $task = new Task;
   
        return view('tasks.create', [
            'task' => $task,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
    public function store(Request $request)
    {
        // メッセージを作成
        $task = new Task;
        $task->content = $request->content;
        $task->status = $request->status;
        $task->user_id = \Auth::id();
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
        
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        
        if (\Auth::id() !== $task->user_id) {
            return redirect('/');
        }

        // メッセージ詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        
        if (\Auth::id() !== $task->user_id) {
            return redirect('/');
        }

        // メッセージ編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $task = Task::findOrFail($id);
        
        if (\Auth::id() !== $task->user_id) {
            return redirect('/');
        }
        
        $task ->content = $request->content;
        $task ->save();
        
        
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        if (\Auth::id() !== $task->user_id) {
            return redirect('/');
        }
        
        // タスクを削除
        $task ->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
        
    }
    
}