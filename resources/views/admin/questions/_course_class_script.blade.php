{{-- Course → Class cascading selects.
     Expects: #courseSelect and #classSelect (with optional data-selected for preselecting). --}}
@push('js')
<script>
    $(document).ready(function () {
        var classUrlTemplate = "{{ route('course.classes.json', ['product' => 'PRODUCT_ID']) }}";
        var $course = $('#courseSelect');
        var $class = $('#classSelect');

        function loadClasses(courseId, preselect) {
            if (!courseId) {
                $class.prop('disabled', true).html('<option value="">— Select a course first —</option>');
                return;
            }

            $class.prop('disabled', true).html('<option value="">Loading classes...</option>');

            $.get(classUrlTemplate.replace('PRODUCT_ID', courseId), function (res) {
                var options = '<option value="">— Whole course (no specific class) —</option>';
                var lastSection = null;
                var openGroup = false;

                (res.classes || []).forEach(function (c) {
                    if (c.section !== lastSection) {
                        if (openGroup) options += '</optgroup>';
                        if (c.section) {
                            options += '<optgroup label="' + $('<div>').text(c.section).html() + '">';
                            openGroup = true;
                        } else {
                            openGroup = false;
                        }
                        lastSection = c.section;
                    }
                    var sel = (preselect && String(preselect) === String(c.id)) ? ' selected' : '';
                    options += '<option value="' + c.id + '"' + sel + '>' + $('<div>').text(c.title).html() + '</option>';
                });
                if (openGroup) options += '</optgroup>';

                if ((res.classes || []).length === 0) {
                    options = '<option value="">— This course has no classes yet —</option>';
                }

                $class.html(options).prop('disabled', false);
            }).fail(function () {
                $class.html('<option value="">Could not load classes</option>').prop('disabled', false);
            });
        }

        $course.on('change', function () {
            loadClasses($(this).val(), null);
        });

        // Preselect on page load (edit form / save-and-add-another)
        if ($course.val()) {
            loadClasses($course.val(), $class.data('selected'));
        }
    });
</script>
@endpush
