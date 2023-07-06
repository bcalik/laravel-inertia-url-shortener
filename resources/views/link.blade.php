<!doctype html>
<html lang="">
<head>
    <script src="/assets/ua-parser.min.js"></script>
    <!--suppress JSUnresolvedVariable -->
    <script>
        const parser = new UAParser();
        const data = {{ Js::from($link->toArray()) }};

        function handleRedirect() {
            if (parser.getOS().name === 'iOS') {
                window.location.href = data.ios_url;
                return;
            }

            if (
                (parser.getDevice().type === 'mobile' || parser.getDevice().type === 'tablet')
                && parser.getDevice().vendor === 'Huawei'
            ) {
                window.location.href = data.huawei_url;
                return;
            }

            if (parser.getOS().name.includes('Android')) {
                window.location.href = data.android_url;
                return;
            }

            window.location.href = data.fallback_url;
        }

        function initParser() {
            if (! data.fallback_url) {
                handleRedirect();
            }

            setTimeout(function () {
                const now = new Date().valueOf();
                setTimeout(function () {
                    if (new Date().valueOf() - now > 100) return;
                    handleRedirect();
                }, 25);
                window.location.href = data.app_url;
            }, 5);
        }

        initParser();
    </script>
    <title>...</title>
</head>
<body>
    {!! $link->html !!}
</body>
</html>
