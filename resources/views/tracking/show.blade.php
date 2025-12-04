@extends('layouts.app')

@section('title', 'Tracking Artikel - ' . ($settings['site_name'] ?? 'Naskah Prima'))

@section('content')
<section class="tracking-section">
    <div class="container">
        <div class="tracking-card">
            <!-- Header -->
            <div class="tracking-header">
                <h1>Status Artikel Anda</h1>
                <p>Halo <strong>{{ $client->nama_lengkap }}</strong>, berikut status artikel Anda:</p>
            </div>

            @if($client->naskah)
            <!-- Article Info -->
            <div class="tracking-info">
                <div class="info-item">
                    <span class="info-label">Judul Artikel</span>
                    <span class="info-value">{{ $client->naskah->judul_naskah }}</span>
                </div>
                
                @if($client->naskah->mitraJurnal)
                <div class="info-item">
                    <span class="info-label">Jurnal Tujuan</span>
                    <span class="info-value">{{ $client->naskah->mitraJurnal->nama_jurnal }}</span>
                </div>
                @endif
                
                <div class="info-item">
                    <span class="info-label">Tanggal Masuk</span>
                    <span class="info-value">{{ $client->naskah->tanggal_masuk->translatedFormat('d F Y') }}</span>
                </div>
                
                @if($client->naskah->target_bulan_publish)
                <div class="info-item">
                    <span class="info-label">Target Publish</span>
                    <span class="info-value">{{ $client->naskah->target_bulan_publish }}</span>
                </div>
                @endif

                @if($client->naskah->tanggal_published)
                <div class="info-item">
                    <span class="info-label">Tanggal Published</span>
                    <span class="info-value success">{{ $client->naskah->tanggal_published->translatedFormat('d F Y') }}</span>
                </div>
                @endif
            </div>

            <!-- Status Timeline -->
            <div class="tracking-timeline">
                <h3>Progress Status</h3>
                
                @php
                    $statuses = ['Draft', 'Submitted', 'Under Review', 'Revision', 'Accepted', 'Published'];
                    $currentStatus = $client->naskah->status;
                    $currentIndex = array_search($currentStatus, $statuses);
                    $isRejected = $currentStatus === 'Rejected';
                @endphp

                @if($isRejected)
                <div class="timeline-rejected">
                    <div class="rejected-icon">✗</div>
                    <p>Mohon maaf, artikel Anda tidak dapat dilanjutkan.</p>
                    <p>Silakan hubungi kami untuk informasi lebih lanjut.</p>
                </div>
                @else
                <div class="timeline">
                    @foreach($statuses as $index => $status)
                    <div class="timeline-item {{ $index <= $currentIndex ? 'completed' : '' }} {{ $index == $currentIndex ? 'current' : '' }}">
                        <div class="timeline-dot">
                            @if($index < $currentIndex)
                                ✓
                            @elseif($index == $currentIndex)
                                ●
                            @else
                                ○
                            @endif
                        </div>
                        <div class="timeline-content">
                            <span class="timeline-status">{{ $status }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Catatan Progress -->
            @if($client->naskah->catatan_progress)
            <div class="tracking-notes">
                <h3>Catatan Progress</h3>
                <div class="notes-content">
                    {!! nl2br(e($client->naskah->catatan_progress)) !!}
                </div>
            </div>
            @endif

            @else
            <!-- No Naskah -->
            <div class="tracking-empty">
                <div class="empty-icon">📄</div>
                <h3>Belum Ada Artikel</h3>
                <p>Data artikel Anda belum tersedia. Silakan hubungi kami jika ada pertanyaan.</p>
            </div>
            @endif

            <!-- CTA -->
            <div class="tracking-cta">
                <p>Ada pertanyaan tentang artikel Anda?</p>
                <a href="{{ $whatsappUrl }}" class="btn btn-primary" target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.tracking-section {
    min-height: 100vh;
    padding: calc(80px + 2rem) 0 4rem;
    background: linear-gradient(135deg, #F8F9FA 0%, #E8E5F4 100%);
}

.tracking-card {
    max-width: 700px;
    margin: 0 auto;
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.tracking-header {
    background: linear-gradient(135deg, #554D89 0%, #7C3AED 100%);
    color: white;
    padding: 2rem;
    text-align: center;
}

.tracking-header h1 {
    font-size: 1.75rem;
    margin-bottom: 0.5rem;
}

.tracking-header p {
    opacity: 0.9;
    margin: 0;
}

.tracking-info {
    padding: 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: #6b7280;
    font-size: 0.875rem;
}

.info-value {
    font-weight: 600;
    color: #1f2937;
    text-align: right;
    max-width: 60%;
}

.info-value.success {
    color: #10b981;
}

.tracking-timeline {
    padding: 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.tracking-timeline h3 {
    margin-bottom: 1.5rem;
    font-size: 1.125rem;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e5e7eb;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-dot {
    position: absolute;
    left: -2rem;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    color: #9ca3af;
    z-index: 1;
}

.timeline-item.completed .timeline-dot {
    background: #10b981;
    color: white;
}

.timeline-item.current .timeline-dot {
    background: #554D89;
    color: white;
    box-shadow: 0 0 0 4px rgba(85, 77, 137, 0.2);
}

.timeline-status {
    font-weight: 500;
    color: #6b7280;
}

.timeline-item.completed .timeline-status {
    color: #10b981;
}

.timeline-item.current .timeline-status {
    color: #554D89;
    font-weight: 700;
}

.timeline-rejected {
    text-align: center;
    padding: 2rem;
    background: #fef2f2;
    border-radius: 12px;
}

.rejected-icon {
    width: 60px;
    height: 60px;
    background: #ef4444;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin: 0 auto 1rem;
}

.tracking-notes {
    padding: 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.tracking-notes h3 {
    margin-bottom: 1rem;
    font-size: 1.125rem;
}

.notes-content {
    background: #f9fafb;
    padding: 1rem;
    border-radius: 8px;
    color: #4b5563;
    line-height: 1.6;
}

.tracking-empty {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.tracking-cta {
    padding: 2rem;
    text-align: center;
    background: #f9fafb;
}

.tracking-cta p {
    margin-bottom: 1rem;
    color: #6b7280;
}

@media (max-width: 640px) {
    .info-item {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .info-value {
        text-align: left;
        max-width: 100%;
    }
}
</style>
@endpush