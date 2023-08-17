<!DOCTYPE html>
<html>

<head>
	<title>Page Title</title>
</head>

<body>

</body>

@if($paginator->hasPages() || $paginator->onFirstPage())
<nav class="roberto-pagination wow fadeInUp mb-100" data-wow-delay="600ms" style="visibility: visible; animation-delay: 600ms; animation-name: fadeInUp;">
	<ul class="pagination">
		@if ($paginator->onFirstPage())
		<li class="page-item disabled">
			<a class="page-link" href="#"
			tabindex="-1">Previous</a>
		</li>
		@else
		<li class="page-item"><a class="page-link"
			href="{{ $paginator->previousPageUrl() }}">
				Previous</a>
		</li>
		@endif

		@foreach ($elements as $element)
		@if (is_string($element))
		<li class="page-item disabled">{{ $element }}</li>
		@endif

		@if (is_array($element))
		@foreach ($element as $page => $url)
		@if ($page == $paginator->currentPage())
		<li class="page-item">
			<a class="page-link" style="color:#fff;background-color:#1cc3b2;">{{ $page }}</a>
		</li>
		@else
		<li class="page-item">
			<a class="page-link"
			href="{{ $url }}">{{ $page }}</a>
		</li>
		@endif
		@endforeach
		@endif
		@endforeach

		@if ($paginator->hasMorePages())
		<li class="page-item">
			<a class="page-link"
			href="{{ $paginator->nextPageUrl() }}"
			rel="next">Next</a>
		</li>
		@else
		<li class="page-item disabled">
			<a class="page-link" href="#">Next</a>
		</li>
		@endif
	</ul>
</nav>
@endif

</html>