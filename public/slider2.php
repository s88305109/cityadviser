<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slider Page 2</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="/css/splide/splide.min.css">
	<script src="/js/splide/splide.min.js"></script>

	<style>
		html,body{height:100%} 
		.splide, .splide__track, .splide__list, .inner-page, .inner-container  {
			height: 100%;
		}
		.inner-page h2 {
			text-align: center;
			margin-top: 0.5em;
		}
		.inner-page .inner-container {
			height: calc(100% - 100px);
			padding: 0.5em;
			margin: 0.5em;
			border: 1px solid #CCC;
			border-radius: 15px;
			background-color: #F8F9FA;
		}
		.inner-container.sys01 { background-color: #bff3ff; }
		.inner-container.sys02 { background-color: #ffc6bf; }
		.inner-container.sys03 { background-color: #bfffc7; }
	</style>
</head>
<body>
	<div class="splide">
		<div class="splide__track">
			<ul class="splide__list">
				<li class="splide__slide">
					<div class="inner-page">
						<h2>客戶管理</h2>
						<div class="inner-container sys01">Content</div>
					</div>
				</li>
				<li class="splide__slide">
					<div class="inner-page">
						<h2>Slide 02</h2>
						<div class="inner-container sys02">Content</div>
					</div>
				</li>
				<li class="splide__slide">
					<div class="inner-page">
						<h2>Slide 03</h2>
						<div class="inner-container sys03">Content</div>
					</div>						
				</li>
				<li class="splide__slide">
					<div class="inner-page">
						<h2>Slide 04</h2>
						<div class="inner-container">Content</div>
					</div>						
				</li>
				<li class="splide__slide">
					<div class="inner-page">
						<h2>Slide 05</h2>
						<div class="inner-container">Content</div>
					</div>						
				</li>
				<li class="splide__slide">
					<div class="inner-page">
						<h2>Slide 06</h2>
						<div class="inner-container">Content</div>
					</div>						
				</li>
			</ul>
		</div>
	</div>

	<script>
		new Splide( '.splide', {
			type   : 'loop',
			padding: {
				right: '2rem',
				left : '2rem',
			},
			pagination : false,
			arrows : false,
		} ).mount();
	</script>

</body>
</html>
