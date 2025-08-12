<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'vendor_id',
        'project_id',
        'job_status',
        'problem_status',
        'problem_details',
        'estimated_pull',
        'actual_pull',
        'estimated_tracing',
        'actual_tracing',
    ];

    // Relasi ke Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // Relasi ke Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
