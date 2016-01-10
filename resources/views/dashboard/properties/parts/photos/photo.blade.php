<div class="image">
    <img src="{{cloudinary_image($imageId, ['width' => 225, 'height' => 150, 'crop' => 'fill'])}}" height="150"
         width="225" alt="{{$property->address_firstline}}"/>
    <div class="overlay">
        <div class="expand">
            <div class="top half">
                <a href="{{cloudinary_image($imageId)}}" class="expand" data-gallery=""><i
                            class="glyphicon glyphicon-zoom-in"></i></a>
            </div>
            <div class="bottom half">
                <a href="{{ route('delete_property_image', ['propertyId' => $property->id, 'imageId' => $imageId]) }}"
                   class="expand left remove"><i class="glyphicon glyphicon-remove"></i></a>
                <a href="#" class="expand right edit"><i class="glyphicon glyphicon-pencil"></i></a>
            </div>
            <a href="#" class="close-overlay hidden">x</a>
        </div>
    </div>
</div>