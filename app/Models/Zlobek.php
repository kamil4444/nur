<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zlobek extends Model
{
    use HasFactory;

    protected $fillable = [
        "institution_type", 
        "name", 
        "localization", 
        "webpage", 
        "email", 
        "phone_num", 
        "places_number", 
        "num_of_children_registrations", 
        "monthly_payment", 
        "hours_payment_after_10_hours", 
        "hours_payment", 
        "monthly_payment_for_food", 
        "daily_payment_for_food", 
        "sales", 
        "open_time", 
        "is_adapted_for_the_disabled", 
        "host_entity_name", 
        "host_entity_address", 
        "host_entity_nip", 
        "host_entity_regon", 
        "host_entity_registry_position", 
        "host_entity_webpage", 
        "does_host_entity_work"
    ];
}
