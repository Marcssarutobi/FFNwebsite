<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Event;
use App\Models\Expeditions;
use App\Models\FungiEducation;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Titre, description et aperçu de partage de chaque page publique, écrits côté serveur
// (WhatsApp, Facebook, LinkedIn et Google lisent le HTML sans exécuter le JavaScript).
class SeoController extends Controller
{
    const SITE = 'Fungi For Nature';
    const DEFAULT_IMAGE = '/assets/images/main-slider/direct.JPG';
    const DEFAULT_DESCRIPTION = 'Fungi For Nature is an NGO based in Parakou, Benin, working to document, protect and promote mushrooms through scientific research, education and community projects.';

    // Pages fixes du site : chemin => [titre, description]
    const PAGES = [
        '' => [null, self::DEFAULT_DESCRIPTION],
        'aboutUs' => ['About us', 'Discover Fungi For Nature, our mission, our motto and our goals for the conservation of fungi in Benin.'],
        'domain' => ['Field of intervention', 'Our areas of work: mycological research, sustainable agriculture, education, environmental mycology, biodiversity and ecosystem conservation.'],
        'advisor' => ['Advisors', 'Meet the scientific advisors who guide the work of Fungi For Nature.'],
        'team' => ['Our team', 'Meet the team behind Fungi For Nature, committed to the study and protection of fungi in Benin.'],
        'project' => ['Our projects', 'Research, conservation and community projects led by Fungi For Nature to protect and promote mushrooms.'],
        'fungiEducation' => ['Fungi Education', 'Educational activities and resources from Fungi For Nature to raise awareness about the importance of fungi.'],
        'expeditions' => ['Expeditions', 'Field expeditions by Fungi For Nature to discover, collect and document the fungi of Benin.'],
        'scientificPapers' => ['Scientific papers', 'Scientific publications by the Fungi For Nature team on the diversity and uses of fungi.'],
        'reports' => ['Reports', 'Activity and project reports published by Fungi For Nature.'],
        'annualReports' => ['Annual reports', 'Annual reports of Fungi For Nature: activities, results and outlook.'],
        'mycrl' => ['Mycological Research and Innovation (MycRI)', 'MycRI: our mycological research and innovation programme to document and better understand the fungi of Benin.'],
        'agrisa' => ['Sustainable Agriculture and Food Security (AgriSA)', 'AgriSA: using fungi to support sustainable agriculture and food security in Benin.'],
        'edumyco' => ['Fungal Education, Awareness and Valorization (EduMyco)', 'EduMyco: education, awareness and valorization of fungi with communities and schools.'],
        'mycoenv' => ['Environmental Mycology (MycoEnv)', 'MycoEnv: environmental mycology, including the restoration of polluted ecosystems through mycoremediation.'],
        'bioclim' => ['Biodiversity and Climate Change (BioClim)', 'BioClim: the role of fungi in biodiversity and in the response to climate change.'],
        'ecomyco' => ['Fungal and Ecosystem Conservation (EcoMyCo)', 'EcoMyCo: conservation of fungi and of the ecosystems they sustain.'],
        'event' => ['Events', 'Upcoming and past events organised or attended by Fungi For Nature.'],
        'blog' => ['Blog', 'News and articles from Fungi For Nature about fungi, sustainability and nature.'],
        'gallery' => ['Gallery', 'Photos of mushrooms, field work and activities of Fungi For Nature.'],
        'videos' => ['Videos', 'Videos of Fungi For Nature: field work, events and educational content about fungi.'],
        'contact' => ['Contact us', 'Contact Fungi For Nature in Parakou, Benin: partnerships, volunteering, research and media enquiries.'],
    ];

    // Pages de détail : préfixe d'URL => [modèle, champ de description, ne garder que les contenus publiés]
    const DETAILS = [
        'blogsingle' => [Blog::class, 'brief_description', true],
        'singleproject' => [Project::class, 'brief_description', true],
        'eventsingle' => [Event::class, 'brefdescription', true],
        'expeditionSingle' => [Expeditions::class, 'brefdescription', false],
        'fungiEducationSingle' => [FungiEducation::class, 'brief_description', false],
    ];

    // Aperçus internes de l'admin : jamais indexés
    const PREVIEWS = ['projectpreview', 'eventpreview', 'blogpreview', 'fungiEducationpreview'];

    public function page(Request $request)
    {
        $seo = $this->resolve($request->path());
        return response()->view('welcome', ['seo' => $seo], $seo['status']);
    }

    public function meta(Request $request)
    {
        return response()->json($this->resolve((string) $request->query('path', '/')));
    }

    public function sitemap()
    {
        $urls = [];
        foreach (array_keys(self::PAGES) as $path) {
            $urls[] = ['loc' => url($path), 'lastmod' => null];
        }

        foreach (self::DETAILS as $prefix => [$model, , $publishedOnly]) {
            $query = $model::query()->select(['slug', 'updated_at']);
            if ($publishedOnly) {
                $query->where('status', 'published');
            }
            foreach ($query->get() as $row) {
                $urls[] = ['loc' => url("$prefix/{$row->slug}"), 'lastmod' => optional($row->updated_at)->toAtomString()];
            }
        }

        foreach (Team::select(['slug', 'updated_at'])->get() as $member) {
            $urls[] = ['loc' => url("details/{$member->slug}"), 'lastmod' => optional($member->updated_at)->toAtomString()];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $url) {
            $xml .= '  <url><loc>' . e($url['loc']) . '</loc>' . ($url['lastmod'] ? '<lastmod>' . $url['lastmod'] . '</lastmod>' : '') . "</url>\n";
        }
        $xml .= '</urlset>' . "\n";

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    private function resolve(string $path): array
    {
        $path = trim(parse_url($path, PHP_URL_PATH) ?? '', '/');
        $segments = $path === '' ? [] : explode('/', $path);

        // Pages fixes
        if (count($segments) <= 1 && array_key_exists($segments[0] ?? '', self::PAGES)) {
            [$title, $description] = self::PAGES[$segments[0] ?? ''];
            return $this->build($title, $description, null, $path);
        }

        if (count($segments) === 2) {
            [$prefix, $slug] = $segments;

            if (isset(self::DETAILS[$prefix])) {
                [$model, $field, $publishedOnly] = self::DETAILS[$prefix];
                $query = $model::where('slug', $slug);
                if ($publishedOnly) {
                    $query->where('status', 'published');
                }
                $item = $query->first();
                if ($item) {
                    return $this->build($item->title, $item->{$field}, $item->image, $path, 'article');
                }
            }

            if ($prefix === 'details') {
                $member = Team::where('slug', $slug)->first();
                if ($member) {
                    $description = $member->brief_description ?: trim($member->name . ' – ' . $member->profession, ' –');
                    return $this->build($member->name, $description, $member->image, $path, 'profile');
                }
            }

            if ($prefix === 'catDetails' && ctype_digit($slug)) {
                $category = Category::find($slug);
                if ($category) {
                    return $this->build($category->name . ' projects', 'Projects of Fungi For Nature in the category ' . $category->name . '.', null, $path);
                }
            }

            if (in_array($prefix, self::PREVIEWS, true)) {
                return $this->build('Preview', null, null, $path, 'website', 200, true);
            }
        }

        return $this->build('Page not found', 'The page you are looking for does not exist or has been moved.', null, $path, 'website', 404, true);
    }

    private function build(?string $title, ?string $description, ?string $image, string $path, string $type = 'website', int $status = 200, bool $noindex = false): array
    {
        $description = Str::limit(trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags((string) $description), ENT_QUOTES | ENT_HTML5, 'UTF-8'))), 160, '…');

        return [
            'title' => $title ? $title . ' | ' . self::SITE : self::SITE . ' – Protecting and promoting mushrooms in Benin',
            'description' => $description !== '' ? $description : self::DEFAULT_DESCRIPTION,
            'image' => url($image ?: self::DEFAULT_IMAGE),
            'url' => url($path),
            'type' => $type,
            'status' => $status,
            'noindex' => $noindex,
        ];
    }
}
