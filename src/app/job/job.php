<?php

class Job {

    public const ROOT = 0;
    public const ADMIN = 1;
    public const USER = 2;

    private Int $id;
    private String $name;
    private Int $duration;
    private Int $priority;
    private Int $deadline;
    private Int $userType; // ROOT, ADMIN, USER

    private static Int $idIncrementor = 0;

    public function __construct(
        String $name,
        Int $duration,
        Int $priority,
        Int $deadline,
        Int $userType,
    ) {
        static::$idIncrementor++;

        $this->id = static::$idIncrementor;
        $this->name = $name;
        $this->duration = $duration;
        $this->priority = $priority;
        $this->deadline = $deadline;
        $this->userType = $userType;
    }

    public function GetID(): Int {
        return $this->id;
    }

    public function GetName(): String {
        return $this->name;
    }

    public function GetDuration(): Int {
        return $this->duration;
    }

    public function GetPriority(): Int {
        return $this->priority;
    }

    public function GetDeadline(): Int {
        return $this->deadline;
    }

    public function GetUserType(): Int {
        return $this->userType;
    }

}