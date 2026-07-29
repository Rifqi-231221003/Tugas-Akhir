<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index()
    {
        // Cache sitemap selama 24 jam (86400 detik)
        $xml = Cache::remember('sitemap', 86400, function () {
            // Get all exchange rates (product1 to product2)
            $exchanges = Exchange::all();
            
            // Get all active products
            $products = Product::where('status', 'Active')->get();
            
            // ========== 1. STATIC PAGES (konten tetap / jarang berubah) ==========
            $staticPages = [
                ['loc' => '/privacy-policy', 'priority' => '0.7', 'changefreq' => 'monthly'],
                ['loc' => '/contact-us', 'priority' => '0.7', 'changefreq' => 'monthly'],
                ['loc' => '/track-transaction', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ];
            
            // ========== 2. DYNAMIC PAGES (konten berubah sesuai data/logika) ==========
            $dynamicPages = [
                ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],   
                ['loc' => '/exchange-rate', 'priority' => '0.9', 'changefreq' => 'daily'],
            ];
            
            // Mulai XML
            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
            
            // ========== ADD STATIC PAGES ==========
            foreach ($staticPages as $page) {
                $xml .= $this->generateUrlTag($page['loc'], $page['changefreq'], $page['priority']);
            }
            
            // ========== ADD DYNAMIC PAGES ==========
            foreach ($dynamicPages as $page) {
                $xml .= $this->generateUrlTag($page['loc'], $page['changefreq'], $page['priority']);
            }
            
            // ========== ADD EXCHANGE RATE DETAIL PAGES ==========
            foreach ($exchanges as $exchange) {
                $slug = strtolower(str_replace(' ', '-', $exchange->product1)) . '-to-' . strtolower(str_replace(' ', '-', $exchange->product2));
                $xml .= $this->generateUrlTag('/exchange-rate/' . $slug, 'daily', '0.9');
            }
            
            // ========== (OPSIONAL) ADD PRODUCT PAGES ==========
            // Jika setiap produk punya halaman sendiri, uncomment di bawah
            /*
            foreach ($products as $product) {
                $productSlug = strtolower(str_replace(' ', '-', $product->name));
                $xml .= $this->generateUrlTag('/product/' . $productSlug, 'weekly', '0.6');
            }
            */
            
            $xml .= '</urlset>';
            
            return $xml;
        });
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    /**
     * Helper method untuk generate URL tag XML
     */
    private function generateUrlTag($loc, $changefreq, $priority)
    {
        return '    <url>' . "\n" .
               '        <loc>' . url($loc) . '</loc>' . "\n" .
               '        <lastmod>' . Carbon::now()->toDateString() . '</lastmod>' . "\n" .
               '        <changefreq>' . $changefreq . '</changefreq>' . "\n" .
               '        <priority>' . $priority . '</priority>' . "\n" .
               '    </url>' . "\n";
    }
    
    // Method untuk clear cache (bisa dipanggil via URL /sitemap-clear)
    public function clearCache()
    {
        Cache::forget('sitemap');
        return response()->json(['message' => 'Sitemap cache cleared. New sitemap will be generated on next visit.']);
    }
}