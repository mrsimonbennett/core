<div class="ibox-content  p-xl m-t">
    <h2>Photo Gallery</h2>
    <link href="/css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
    <link href="/css/gallery-overlay.css" rel="stylesheet"/>
    <script src="/js/plugins/dropzone/dropzone.js"></script>

    <div class="lightBoxGallery" data-photo-prototype="@einclude('dashboard.properties.parts.photos.photo', ['imageId' => '__IMG_URL__'])">
        @forelse($property->images as $image)
            @include('dashboard.properties.parts.photos.photo', ['imageId' => $image->image_id])
        @empty
            <p>If you own this property, upload some photos by dragging and dropping them here.</p>
        @endforelse

        <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
        <div id="blueimp-gallery" class="blueimp-gallery">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>

    </div>
    <form action="/properties/{{$property->id}}/photos" method="post" enctype="multipart/form-data" class="dropzone" id="gallery-dz">
    </form>
</div>
