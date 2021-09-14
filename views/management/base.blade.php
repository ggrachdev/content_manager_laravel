<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $TITLE }}</title>
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class="bg-blue-900 pt-5 pb-5">
            <div class="container mx-auto px-20">
                <a class="text-white font-medium">{!! $LOGO_TEXT !!}</a>
            </div>
        </nav>
        <div class="container mx-auto px-20 flex flex-wrap">
            <div class="w-1/5 p-5 pr-0 bg-gray-100">
                {!! $menu !!}
            </div>
            <div class="w-4/5 p-5">
                {!! $work_region !!}
            </div>
        </div>

        <script>
            function removeConfirm(link, confirmText)
            {
                var ask = confirm(confirmText);
                if (ask) {
                    window.location = link;
                }
            }
        </script>
    </body>
</html>