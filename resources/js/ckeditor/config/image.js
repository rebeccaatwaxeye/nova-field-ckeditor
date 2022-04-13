/**
 * https://ckeditor.com/docs/ckeditor5/latest/features/image.html
 */
export default {
    image: {
        upload: {
            types: ['gif', 'png', 'jpg', 'jpeg', 'webp']
        },
        toolbar: [
            'mediaBrowser',
            'imageStyle:block',
            'imageStyle:alignLeft',
            'imageStyle:alignCenter',
            'imageStyle:alignRight',
            'imageTextAlternative',
        ],
        styles: [
            'block',
            'alignLeft',
            'alignCenter',
            'alignRight',
        ]
    }
}
