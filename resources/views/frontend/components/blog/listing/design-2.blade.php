<div class="row g-3 g-lg-4">
    @forelse ($blogs as $blog)
        <div class="col-6 col-lg-3">
            @include($blogCardView, ['blog' => $blog])
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fa-solid fa-box-open fs-1 text-muted mb-3"></i>
                <h5 class="mb-2">No Blogs Found</h5>
                <p class="text-muted mb-0">There are no blogs available at the moment.</p>
            </div>
        </div>
    @endforelse
</div>
@if ($blogs->hasPages())
    <div class="d-flex justify-content-center mt-5 blogs-pagination">
        {{ $blogs->withQueryString()->links() }}
    </div>
@endif