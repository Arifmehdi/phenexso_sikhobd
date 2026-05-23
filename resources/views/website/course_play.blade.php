@extends('website.layouts.sikhobd')

@section('title', (lp($product, 'name') ?? 'Course Player') . ' — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .player-layout {
        display: grid;
        grid-template-columns: 1fr 350px;
        height: calc(100vh - 150px);
        min-height: 600px;
        background: #f8f9fa;
        overflow: hidden;
    }

    .player-main {
        overflow-y: auto;
        padding: 30px;
        background: #fff;
    }

    .player-sidebar {
        background: #fff;
        border-left: 1px solid var(--border);
        overflow-y: auto;
        padding: 20px;
    }

    .player-header {
        background: var(--primary);
        color: #fff;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .player-header h1 {
        font-size: 20px;
        margin: 0;
        color: #fff;
    }

    .progress-container {
        width: 200px;
        background: rgba(255,255,255,0.2);
        height: 8px;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar-fill {
        background: var(--accent);
        height: 100%;
        transition: width 0.3s;
    }

    .lesson-item {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 8px;
        border: 1px solid var(--border);
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .lesson-item:hover {
        background: var(--bg-soft);
    }

    .lesson-item.active {
        background: rgba(43, 37, 83, 0.05);
        border-color: var(--primary);
    }

    .section-title {
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        color: var(--text-soft);
        margin: 20px 0 10px;
        padding-bottom: 5px;
        border-bottom: 1px solid var(--border);
    }

    #player-content-area {
        max-width: 900px;
        margin: 0 auto;
    }

    .nav-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border);
    }

    .lesson-tutorial {
        margin-top: 30px;
        line-height: 1.8;
        font-size: 16px;
        color: var(--text-main);
    }

    @media (max-width: 992px) {
        .player-layout {
            grid-template-columns: 1fr;
            height: auto;
        }
        .player-sidebar {
            border-left: none;
            border-top: 1px solid var(--border);
        }
    }
</style>
@endpush

@section('content')
<div class="player-header">
    <div>
        <a href="{{ route('courseDetail', $product->slug) }}" style="color: #fff; text-decoration: none; margin-right: 15px;">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
        <h1>{{ lp($product, 'name') }}</h1>
    </div>
    <div style="display: flex; align-items: center; gap: 15px;">
        <span style="font-size: 14px;">Progress: <span id="progress-percent-val">{{ count($completions) > 0 ? round((count($completions) / $lessons->count()) * 100) : 0 }}</span>%</span>
        <div class="progress-container">
            <div class="progress-bar-fill" id="progress-bar-fill" style="width: {{ count($completions) > 0 ? round((count($completions) / $lessons->count()) * 100) : 0 }}%;"></div>
        </div>
    </div>
</div>

<div class="player-layout">
    <!-- Main Content Area -->
    <main class="player-main">
        <div id="player-content-area">
            <div class="nav-controls">
                <h2 id="current-lesson-title" style="margin:0; font-size: 24px; color: var(--primary);">Select a lesson to start</h2>
                <div style="display: flex; gap: 10px;">
                    <button class="btn btn-outline btn-sm" id="btn-prev" onclick="window.prevLesson()" disabled>
                        <i class="fa-solid fa-chevron-left"></i> Previous
                    </button>
                    <button class="btn btn-accent btn-sm" id="btn-next" onclick="window.nextLesson()" disabled>
                        Next <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <div id="media-placeholder" style="text-align: center; padding: 100px 0; color: var(--text-soft);">
                <i class="fa-solid fa-play-circle" style="font-size: 80px; margin-bottom: 20px; opacity: 0.3;"></i>
                <h3>পড়া শুরু করতে ডান পাশের তালিকা থেকে লেসন সিলেক্ট করুন</h3>
            </div>

            <div id="lesson-media-container" style="display: none;"></div>

            <!-- Tabs for Tutorial, Resources, and Q&A -->
            <div id="lesson-tabs-container" style="display: none; margin-top: 30px;">
                <div class="player-tabs" style="display: flex; gap: 20px; border-bottom: 2px solid var(--border); margin-bottom: 20px;">
                    <button class="player-tab-btn active" data-player-tab="tutorial" style="background: none; border: none; padding: 10px 0; font-weight: 700; color: var(--text-soft); cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.2s;">
                        <i class="fa-solid fa-book-open"></i> লেসন টিউটোরিয়াল
                    </button>
                    <button class="player-tab-btn" data-player-tab="resources" style="background: none; border: none; padding: 10px 0; font-weight: 700; color: var(--text-soft); cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.2s;">
                        <i class="fa-solid fa-paperclip"></i> রিসোর্সসমূহ
                    </button>
                    <button class="player-tab-btn" data-player-tab="qa" style="background: none; border: none; padding: 10px 0; font-weight: 700; color: var(--text-soft); cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.2s;">
                        <i class="fa-solid fa-comments"></i> প্রশ্নোত্তর (Q&A)
                    </button>
                </div>

                <div id="player-tab-tutorial" class="player-tab-content" style="display: block;">
                    <div id="lesson-tutorial-container" class="lesson-tutorial"></div>
                </div>

                <div id="player-tab-resources" class="player-tab-content" style="display: none;">
                    <div id="lesson-resources-container" style="background: var(--bg-soft); padding: 20px; border-radius: 12px; border: 1px solid var(--border);">
                        <h4 style="margin-top: 0; color: var(--primary);">ডাউনলোডযোগ্য ফাইল</h4>
                        <div id="resources-list" style="margin-top: 15px;"></div>
                    </div>
                </div>

                <div id="player-tab-qa" class="player-tab-content" style="display: none;">
                    <div style="background: #fff; padding: 20px; border: 1px solid var(--border); border-radius: 12px;">
                        <h4 style="margin-top: 0; color: var(--primary);">আপনার কোনো প্রশ্ন আছে?</h4>
                        <p style="color: var(--text-soft); font-size: 14px;">এই লেসন সম্পর্কে যেকোনো প্রশ্ন থাকলে এখানে লিখুন। ইনস্ট্রাকটর বা অন্য শিক্ষার্থীরা উত্তর দিবে।</p>
                        
                        <div style="margin-top: 20px;">
                            <textarea class="custom-input" rows="3" placeholder="আপনার প্রশ্নটি লিখুন..." style="width: 100%; border-radius: 8px; margin-bottom: 10px;"></textarea>
                            <button class="btn btn-primary btn-sm">প্রশ্ন সাবমিট করুন</button>
                        </div>

                        <div style="margin-top: 30px; border-top: 1px solid var(--border); padding-top: 20px; text-align: center; color: var(--text-soft);">
                            <p><i class="fa-solid fa-info-circle"></i> বর্তমানে কোনো প্রশ্নোত্তর নেই।</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="lesson-footer-actions" style="display: none; margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border);">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; background: var(--bg-soft); padding: 15px; border-radius: 10px; width: fit-content;">
                    <input type="checkbox" id="current-lesson-check" style="width: 20px; height: 20px;" onchange="window.toggleCurrentCompletion()">
                    <span style="font-weight: 600;">এই লেসনটি সম্পন্ন হয়েছে (Mark as Complete)</span>
                </label>
            </div>
        </div>
    </main>

    <!-- Sidebar Curriculum -->
    <aside class="player-sidebar">
        <h3 style="font-size: 18px; margin-bottom: 20px;"><i class="fa-solid fa-list-ul"></i> Course Curriculum</h3>
        
        @forelse($sections as $section)
            <div class="section-group">
                <div class="section-title">{{ lp($section, 'title') }}</div>
                @foreach($section->lessons as $lesson)
                    <div class="lesson-item" data-lesson-id="{{ $lesson->id }}" onclick="window.renderLesson({{ $lesson->id }})">
                        <div class="lesson-status">
                            <i class="fa-solid {{ in_array($lesson->id, $completions) ? 'fa-circle-check text-success' : 'fa-circle' }}" 
                               id="status-icon-{{ $lesson->id }}" style="opacity: 0.6;"></i>
                        </div>
                        <div style="flex-grow: 1;">
                            <div style="font-weight: 600; font-size: 14px;">{{ lp($lesson, 'title') }}</div>
                            <div style="font-size: 12px; color: var(--text-muted);">
                                @if($lesson->video_url || $lesson->video_file) <i class="fa-solid fa-video"></i> @endif
                                @if($lesson->pdf_url) <i class="fa-solid fa-file-pdf"></i> @endif
                                {{ $lesson->duration }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            @foreach($lessons as $lesson)
                <div class="lesson-item" data-lesson-id="{{ $lesson->id }}" onclick="window.renderLesson({{ $lesson->id }})">
                    <div class="lesson-status">
                        <i class="fa-solid {{ in_array($lesson->id, $completions) ? 'fa-circle-check text-success' : 'fa-circle' }}" 
                           id="status-icon-{{ $lesson->id }}" style="opacity: 0.6;"></i>
                    </div>
                    <div style="flex-grow: 1;">
                        <div style="font-weight: 600; font-size: 14px;">{{ lp($lesson, 'title') }}</div>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ $lesson->duration }}</div>
                    </div>
                </div>
            @endforeach
        @endforelse
    </aside>
</div>
@endsection

@push('js')
<script>
    window.allLessons = @json($lessons);
    window.completions = @json($completions);
    window.currentLessonIndex = -1;
    window.storageBase = "{{ asset('storage') }}";

    // Tab Switching Logic
    $(document).on('click', '.player-tab-btn', function() {
        const tab = $(this).data('player-tab');
        $('.player-tab-btn').removeClass('active').css('border-bottom', '3px solid transparent').css('color', 'var(--text-soft)');
        $(this).addClass('active').css('border-bottom', '3px solid var(--accent)').css('color', 'var(--primary)');
        
        $('.player-tab-content').hide();
        $(`#player-tab-${tab}`).show();
    });

    window.renderLesson = function(lessonId) {
        const index = window.allLessons.findIndex(l => l.id == lessonId);
        if (index === -1) return;

        window.currentLessonIndex = index;
        const lesson = window.allLessons[index];

        // UI Updates
        $('#current-lesson-title').text(lesson.title_en || lesson.title_bn);
        $('.lesson-item').removeClass('active');
        $(`.lesson-item[data-lesson-id="${lessonId}"]`).addClass('active');
        $('#media-placeholder').hide();
        $('#lesson-media-container').show().empty();
        $('#lesson-tabs-container').show();
        $('#lesson-tutorial-container').empty();
        $('#resources-list').empty();
        $('#lesson-footer-actions').show();
        
        // Reset Tabs to Tutorial
        $('[data-player-tab="tutorial"]').click();

        // Navigation Buttons
        $('#btn-prev').prop('disabled', index === 0);
        $('#btn-next').prop('disabled', index === window.allLessons.length - 1);

        // Completion Checkbox
        $('#current-lesson-check').prop('checked', window.completions.includes(lessonId));

        // Media Logic
        let mediaHtml = '';
        if (lesson.video_file) {
            mediaHtml = `<video controls style="width: 100%; border-radius: 12px; background:#000; aspect-ratio: 16/9;">
                            <source src="${window.storageBase}/${lesson.video_file}" type="video/mp4">
                         </video>`;
        } else if (lesson.video_url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            const match = lesson.video_url.match(regExp);
            const id = (match && match[2].length == 11) ? match[2] : null;
            if(id && lesson.video_provider === 'youtube') {
                mediaHtml = `<iframe width="100%" style="aspect-ratio: 16/9; border-radius: 12px;" src="https://www.youtube.com/embed/${id}" frameborder="0" allowfullscreen></iframe>`;
            } else {
                mediaHtml = `<div class="alert alert-info">External Video: <a href="${lesson.video_url}" target="_blank">Watch on Provider</a></div>`;
            }
        }

        if (lesson.audio_url) {
            mediaHtml += `<div style="margin-top: 20px; background: var(--bg-muted); padding: 15px; border-radius: 10px;">
                            <p style="margin-bottom: 10px; font-weight: 700;"><i class="fa-solid fa-headphones"></i> Audio Lesson:</p>
                            <audio controls style="width: 100%;"><source src="${window.storageBase}/${lesson.audio_url}" type="audio/mpeg"></audio>
                          </div>`;
        }

        $('#lesson-media-container').html(mediaHtml);

        // Resources Tab Population
        if (lesson.pdf_url) {
            $('#resources-list').append(`
                <div style="display: flex; align-items: center; justify-content: space-between; background: #fff; padding: 15px; border-radius: 10px; border: 1px solid var(--border); margin-bottom: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-file-pdf" style="font-size: 24px; color: #dc3545;"></i>
                        <div>
                            <div style="font-weight: 600;">Lesson Material (PDF)</div>
                            <div style="font-size: 12px; color: var(--text-soft);">Download for offline study</div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <a href="${window.storageBase}/${lesson.pdf_url}" target="_blank" class="btn btn-primary btn-sm">View</a>
                        <a href="${window.storageBase}/${lesson.pdf_url}" download class="btn btn-outline btn-sm">Download</a>
                    </div>
                </div>
            `);
        } else {
            $('#resources-list').html('<p style="color: var(--text-soft); text-align: center; padding: 20px;">এই লেসনের জন্য কোনো ডাউনলোডযোগ্য রিসোর্স নেই।</p>');
        }

        // Tutorial Tab Content
        if (lesson.description) {
            $('#lesson-tutorial-container').html(lesson.description);
        } else {
            $('#lesson-tutorial-container').html('<p style="color: var(--text-soft); text-align: center; padding: 20px;">এই লেসনের কোনো টেক্সট টিউটোরিয়াল নেই।</p>');
        }

        // Scroll to top of main area
        $('.player-main').animate({ scrollTop: 0 }, 300);
    };

    window.nextLesson = function() {
        if (window.currentLessonIndex < window.allLessons.length - 1) {
            window.renderLesson(window.allLessons[window.currentLessonIndex + 1].id);
        }
    };

    window.prevLesson = function() {
        if (window.currentLessonIndex > 0) {
            window.renderLesson(window.allLessons[window.currentLessonIndex - 1].id);
        }
    };

    window.toggleCurrentCompletion = function() {
        const lesson = window.allLessons[window.currentLessonIndex];
        const isChecked = $('#current-lesson-check').is(':checked');
        
        $.ajax({
            url: "{{ route('lesson.toggleCompletion') }}",
            type: "POST",
            data: { lesson_id: lesson.id, _token: "{{ csrf_token() }}" },
            success: function() {
                // Update local completion state
                if (isChecked) {
                    if (!window.completions.includes(lesson.id)) window.completions.push(lesson.id);
                    $(`#status-icon-${lesson.id}`).removeClass('fa-circle').addClass('fa-circle-check text-success');
                } else {
                    window.completions = window.completions.filter(id => id !== lesson.id);
                    $(`#status-icon-${lesson.id}`).removeClass('fa-circle-check text-success').addClass('fa-circle');
                }

                // Update Progress Bar
                const total = window.allLessons.length;
                const done = window.completions.length;
                const percent = Math.round((done / total) * 100);
                $('#progress-percent-val').text(percent);
                $('#progress-bar-fill').css('width', percent + '%');

                showCartNotification('Progress Saved', 'success');
            }
        });
    };

    $(document).ready(function() {
        // Initial tab styling
        $('[data-player-tab="tutorial"]').css('border-bottom', '3px solid var(--accent)').css('color', 'var(--primary)');

        // Automatically start first uncompleted lesson
        let targetLesson = window.allLessons.find(l => !window.completions.includes(l.id));
        if (!targetLesson && window.allLessons.length > 0) targetLesson = window.allLessons[0];
        
        if (targetLesson) window.renderLesson(targetLesson.id);
    });
</script>
@endpush
