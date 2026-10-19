<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Contact;
use App\Models\Event;
use App\Models\Expeditions;
use App\Models\FungiEducation;
use App\Models\Gallery;
use App\Models\Project;
use App\Models\Team;
use App\Models\Video;
use Illuminate\Support\Str;

class DashboardController extends Controller
{

    // Chiffres et listes de l'accueil du back-office
    public function index(){
        $statusOf = function ($model) {
            $counts = $model::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
            return [
                'published' => (int) ($counts['published'] ?? 0),
                'draft' => (int) ($counts['draft'] ?? 0),
                'approbation' => (int) ($counts['approbation'] ?? 0),
            ];
        };

        $pending = collect([
            ['type' => 'Project', 'model' => Project::class, 'page' => '/admins/projects'],
            ['type' => 'Event', 'model' => Event::class, 'page' => '/admins/events'],
            ['type' => 'Blog', 'model' => Blog::class, 'page' => '/admins/blogs'],
        ])->flatMap(function ($item) {
            return $item['model']::with('user:id,nom,prenom')
                ->where('status', 'approbation')
                ->latest('updated_at')
                ->get(['id', 'title', 'user_id', 'updated_at'])
                ->map(fn ($row) => [
                    'type' => $item['type'],
                    'title' => $row->title,
                    'author' => $row->user ? trim($row->user->prenom . ' ' . $row->user->nom) : null,
                    'updated_at' => $row->updated_at,
                    'page' => $item['page'],
                ]);
        })->sortByDesc('updated_at')->values();

        $contacts = Contact::latest()->take(5)->get(['id', 'name', 'email', 'message', 'is_read', 'created_at'])
            ->map(fn ($contact) => [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'excerpt' => Str::limit(strip_tags($contact->message), 90),
                'is_read' => (bool) $contact->is_read,
                'created_at' => $contact->created_at,
            ]);

        $upcomingEvents = Event::where(function ($query) {
                $query->where('start_date', '>=', now())->orWhere('end_date', '>=', now());
            })
            ->orderBy('start_date')
            ->take(4)
            ->get(['id', 'title', 'start_date', 'end_date', 'location', 'status']);

        return response()->json([
            'counts' => [
                'projects' => Project::count(),
                'events' => Event::count(),
                'blogs' => Blog::count(),
                'expeditions' => Expeditions::count(),
                'fungi_education' => FungiEducation::count(),
                'gallery' => Gallery::count(),
                'videos' => Video::count(),
                'teams' => Team::where('type', 'teams')->count(),
                'advisors' => Team::where('type', 'advisors')->count(),
                'contacts' => Contact::count(),
                'unread_contacts' => Contact::where('is_read', false)->count(),
            ],
            'status' => [
                'projects' => $statusOf(Project::class),
                'events' => $statusOf(Event::class),
                'blogs' => $statusOf(Blog::class),
            ],
            'pending' => $pending,
            'contacts' => $contacts,
            'upcoming_events' => $upcomingEvents,
        ]);
    }

}
