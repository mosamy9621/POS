@if(session('success'))
    <script src="{{asset('js/noty.js')}}" type="text/javascript"></script>

    <script>

        new Noty({
            type: 'success',
            layout: 'topRight',
            text: "{{session('success')}}",
            timeout:2000,
            killer:true
        }).show();
    </script>

@endif

