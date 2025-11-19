<?php

namespace App\Enum;

enum Status : string {
    case single = "single";
    case married = "married";
    case widower = "widower";
}