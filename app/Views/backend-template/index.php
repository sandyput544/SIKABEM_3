<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/r-2.3.0/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/datatables.min.css" />
  <link rel="stylesheet" href="/assets/backend_css.css">
</head>

<body>
  <?= $this->include('\backend-template\wrapper-start'); ?>
  <?= $this->include('\backend-template\navbar'); ?>
  <?= $this->include('\backend-template\right-side'); ?>
  <?= $this->include('\backend-template\wrapper-end'); ?>
  <?= $this->include('\backend-template\javascript'); ?>
  <?= $this->renderSection('script'); ?>
</body>

</html>