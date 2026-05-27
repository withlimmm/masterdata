<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach($imageUrls as $item)
    <url>
        <loc>{!! e($item['page_url']) !!}</loc>
        {!! $item['image_xml'] !!}
    </url>
@endforeach
</urlset>
