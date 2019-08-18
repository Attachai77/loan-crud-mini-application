<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Loan CRUD</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
        <meta name="csrf-token" value="{{ csrf_token() }}" />
        <style>
        .col-form-label{
            font-weight: bold;
            text-align: right;
        }
        .btn-light {
            background-color: #e4e4e4;
        }
        </style>
    </head>
    <body>
        <div id="app">
            
            <example-component></example-component>
        </div>
        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>

    </body>
</html>


<script>
    Vue.component('validation-errors', {
        data(){
            return {
                
            }
        },
        props: ['errors'],
        template: `<div v-if="validationErrors">
                    <ul class="alert alert-danger">
                        <li v-for="(value, key, index) in validationErrors">@{{ value }}</li>
                    </ul>
                </div>`,
        computed: {
            validationErrors(){
                let errors = Object.values(this.errors);
                errors = errors.flat();
                return errors;
            }
        }
    })
</script>