<?php

class Task {
    public $id="";
    public $user_id="";
    public $title="";
    public $description="";
    public $status="";
    public $created_at="";

    function __construct(
        $user_id,
        $title,
        $description,
        $status="Pending",
        $created_at="",
        $id=""
    ){
        $this->id=$id;
        $this->user_id=$user_id;
        $this->title=$title;
        $this->description=$description;
        $this->status=$status;
        $this->created_at=$created_at;
    }
}