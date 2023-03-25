<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail</title>
</head>
<body>
    <h1>Al barqy fr - jogjaCamp</h1>

    @if ($tipe == 'create')

        <p>Kategori {{ $category->name }} telah berhasil ditambahkan.</p>
        <a href="http://127.0.0.1:8000/category/{{ $category->id }}/edit">Lihat data</a>

    @else

        <p>Kategori telah dihapus.</p>

    @endif

    <p>terima kasih telah menggunakan layanan kami.</p>
</body>
</html>