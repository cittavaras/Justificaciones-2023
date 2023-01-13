<?php

namespace App\Providers;

// Event aliases
use App\Events\Justification\Submitted as JustificationSubmitted;
use App\Events\Justification\Approved as JustificationApproved;
use App\Events\Justification\Rejected as JustificationRejected;

// Submitted listener aliases
use App\Listeners\Justification\Submitted\SendEmailToStudent as SubmittedSendEmailToStudent;
use App\Listeners\Justification\Submitted\SendEmailToCoordinator as SubmittedSendEmailToCoordinator;

// Approved listener aliases
use App\Listeners\Justification\Approved\SendEmailToStudent as ApprovedSendEmailToStudent;
use App\Listeners\Justification\Approved\SendEmailToTeacher as ApprovedSendEmailToTeacher;

// Rejected listener aliases
use App\Listeners\Justification\Rejected\SendEmailToStudent as RejectedSendEmailToStudent;
use App\Listeners\Justification\Rejected\SendEmailToTeacher as RejectedSendEmailToTeacher;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        JustificationSubmitted::class => [
            SubmittedSendEmailToStudent::class,
            // SubmittedSendEmailToCoordinator::class,
        ],
        JustificationApproved::class => [
            ApprovedSendEmailToStudent::class,
            ApprovedSendEmailToTeacher::class,
        ],
        JustificationRejected::class => [
            RejectedSendEmailToStudent::class,
            //RejectedSendEmailToTeacher::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
