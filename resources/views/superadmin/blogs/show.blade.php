<!DOCTYPE html>
<html>
<head>
    <title>Blog Preview</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            padding: 30px;
        }

        .card {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
        }

        .seo-preview {
            border: 1px solid #ddd;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .seo-title {
            color: #1a0dab;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .seo-url {
            color: #006621;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .seo-description {
            color: #545454;
            font-size: 14px;
        }

        .field {
            margin-bottom: 15px;
        }

        .field label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="card">

    <h2>SEO Preview</h2>

    @php
        $seoTitle = $values->firstWhere('field.name', 'seo_title')?->value ?? 'Your SEO Title';
        $seoDesc  = $values->firstWhere('field.name', 'seo_description')?->value ?? 'Your SEO description will appear here.';
        $url      = url('/blog/' . $blog->id);
    @endphp

    <div class="seo-preview">
        <div class="seo-title">{{ $seoTitle }}</div>
        <div class="seo-url">{{ $url }}</div>
        <div class="seo-description">{{ $seoDesc }}</div>
    </div>

    <h2>Blog Content</h2>

    @foreach($values as $item)
        <div class="field">
            <label>{{ $item->field->label }}</label><br>

            @if($item->field->type === 'file')
                <img src="{{ asset('storage/'.$item->value) }}" width="300">
            @else
                <p>{{ $item->value }}</p>
            @endif
        </div>
    @endforeach

</div>

</body>
</html>
