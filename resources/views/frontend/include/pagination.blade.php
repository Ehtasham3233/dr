@if ($pagination->lastPage() > 1)
    <ul class="pagination">
        <!-- si la pagina actual es distinto a 1 y hay mas de 5 hojas muestro el boton de 1era hoja -->
        <!-- if actual page is not equals 1, and there is more than 5 pages then I show first page button -->
        @if ($pagination->currentPage() != 1 && $pagination->lastPage() >= 5)
            <li lass="first">
                <a href="{{ $pagination->url($pagination->url(1)) }}" >
                    << First
                </a>
            </li>
        @endif

        <!-- si la pagina actual es distinto a 1 muestra el boton de atras -->
        @if($pagination->currentPage() != 1)
            <li class="previous">
                <a href="{{ $pagination->url($pagination->currentPage()-1) }}" >
                    < Previous
                </a>
            </li>
        @endif

        <!-- dibuja las hojas... Tomando un rango de 5 hojas, siempre que puede muestra 2 hojas hacia atras y 2 hacia adelante -->
        <!-- I draw the pages... I show 2 pages back and 2 pages forward -->
        @for($i = max($pagination->currentPage()-2, 1); $i <= min(max($pagination->currentPage()-2, 1)+4,$pagination->lastPage()); $i++)
                <li class="{{ ($pagination->currentPage() == $i) ? ' selected' : '' }}">
                    <a href="{{ $pagination->url($i) }}">{{ $i }}</a>
                </li>
        @endfor

        <!-- si la pagina actual es distinto a la ultima muestra el boton de adelante -->
        <!-- if actual page is not equal last page then I show the forward button-->
        @if ($pagination->currentPage() != $pagination->lastPage())
            <li class="next">
                <a href="{{ $pagination->url($pagination->currentPage()+1) }}" >
                    Next &gt;
                </a>
            </li>
        @endif

        <!-- si la pagina actual es distinto a la ultima y hay mas de 5 hojas muestra el boton de ultima hoja -->
        <!-- if actual page is not equal last page, and there is more than 5 pages then I show last page button -->
        @if ($pagination->currentPage() != $pagination->lastPage() && $pagination->lastPage() >= 5)
            <li class="last">
                <a href="{{ $pagination->url($pagination->lastPage()) }}" >
                    Last &gt;&gt;
                </a>
            </li>
        @endif
    </ul>
@endif
