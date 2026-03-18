
<script>
document.addEventListener('DOMContentLoaded', function() {
    let advantageItemIndex = {{ count(old('advantage.items', (isset($advantage) && isset($advantage['items']) && is_array($advantage['items'])) ? $advantage['items'] : [])) }};
    let suitableItemIndex = {{ count(old('suitable.items', (isset($suitable) && isset($suitable['items']) && is_array($suitable['items'])) ? $suitable['items'] : [])) }};
    let majorItemIndex = {{ count(old('majors', (isset($majors) && is_array($majors)) ? $majors : [])) }};
    let studyMethodItemIndex = {{ count(old('study_method.items', (isset($studyMethod) && isset($studyMethod['items']) && is_array($studyMethod['items'])) ? $studyMethod['items'] : [])) }};
    let studentFeedbackIndex = {{ count(old('feedback.items', (isset($feedback) && isset($feedback['items']) && is_array($feedback['items'])) ? $feedback['items'] : [])) }};
    let degreeValueItemIndex = {{ count(old('value.items', (isset($value) && isset($value['items']) && is_array($value['items'])) ? $value['items'] : [])) }};
    
    // Initialize Select2 for majors and events
    setTimeout(function() {
        if (typeof $.fn.select2 !== 'undefined') {
            $('#selected_major_ids').select2({
                placeholder: 'Chọn các ngành',
                allowClear: true
            }).on('change', function() {
                updateMajorsDetails();
            });
            
            $('#event_post_catalogue_id').select2({
                placeholder: 'Chọn chuyên mục',
                allowClear: true
            });
        }
    }, 500);

    // Update majors details when majors are selected
    function updateMajorsDetails() {
        const selectedIds = $('#selected_major_ids').val() || [];
        // Convert all to string for comparison
        const selectedIdsStr = selectedIds.map(id => String(id));
        const container = $('#majorsDetailsContainer');
        
        // Remove unselected majors first
        container.find('.major-item').each(function() {
            const majorId = $(this).attr('data-major-id') || $(this).data('major-id');
            const majorIdStr = String(majorId);
            if (majorId && !selectedIdsStr.includes(majorIdStr)) {
                $(this).remove();
            }
        });
        
        // Get existing major IDs from DOM AFTER removal (to correctly detect what's still present)
        const existingIds = [];
        container.find('.major-item').each(function() {
            const majorId = $(this).attr('data-major-id') || $(this).data('major-id');
            if (majorId) {
                existingIds.push(String(majorId));
            }
        });
        
        // Add new selected majors
        selectedIds.forEach(function(majorId) {
            const majorIdStr = String(majorId);
            if (!existingIds.includes(majorIdStr)) {
                const majorOption = $('#selected_major_ids option[value="' + majorId + '"]');
                const majorName = majorOption.text();
                const template = `
                    <div class="major-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px;" data-major-id="${majorId}">
                        <input type="hidden" name="majors[${majorItemIndex}][major_id]" value="${majorId}">
                        <h5>${majorName}</h5>
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Hình thức xét tuyển</label>
                                    <input type="text" name="majors[${majorItemIndex}][admission_method]" class="form-control" placeholder="Nhập hình thức xét tuyển">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Thời gian</label>
                                    <input type="text" name="majors[${majorItemIndex}][duration]" class="form-control" placeholder="Nhập thời gian">
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Học phí</label>
                                    <input type="text" name="majors[${majorItemIndex}][tuition]" class="form-control" placeholder="Nhập học phí">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label class="control-label text-left">Địa điểm</label>
                                    <input type="text" name="majors[${majorItemIndex}][location]" class="form-control" placeholder="Nhập địa điểm">
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-4">
                                <div class="form-row">
                                    <label class="control-label text-left">Học phí năm</label>
                                    <input type="text" name="majors[${majorItemIndex}][annual_tuition]" class="form-control" placeholder="Nhập học phí năm">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-row">
                                    <label class="control-label text-left">Số tín chỉ</label>
                                    <input type="text" name="majors[${majorItemIndex}][credits]" class="form-control" placeholder="Nhập số tín chỉ">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-row">
                                    <label class="control-label text-left">Học phí / 1 tín chỉ</label>
                                    <input type="text" name="majors[${majorItemIndex}][tuition_per_credit]" class="form-control" placeholder="Nhập học phí / 1 tín chỉ">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-danger removeMajorItemBtn"><i class="fa fa-trash"></i> Xóa</button>
                            </div>
                        </div>
                    </div>
                `;
                container.append(template);
                majorItemIndex++;
            }
        });
    }
    
    // Add Advantage Item
    document.getElementById('addAdvantageItemBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        const container = document.getElementById('advantageItemsContainer');
        const template = `
            <div class="advantage-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px;">
                <div class="row mb15">
                    <div class="col-lg-12">
                        <div class="form-row">
                            <label class="control-label text-left">Tên</label>
                            <input type="text" name="advantage[items][${advantageItemIndex}][name]" class="form-control" placeholder="Nhập tên">
                        </div>
                    </div>
                </div>
                <div class="row mb15">
                    <div class="col-lg-12">
                        <div class="form-row">
                            <label class="control-label text-left">Mô tả</label>
                            <input type="text" name="advantage[items][${advantageItemIndex}][description]" class="form-control" placeholder="Nhập mô tả">
                        </div>
                    </div>
                </div>
                <div class="row mb15">
                    <div class="col-lg-12">
                        <div class="form-row">
                            <label class="control-label text-left">Icon</label>
                            <input type="text" name="advantage[items][${advantageItemIndex}][icon]" class="form-control upload-image" placeholder="Chọn ảnh icon" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb15">
                    <div class="col-lg-12">
                        <div class="form-row">
                            <label class="control-label text-left">Ghi chú</label>
                            <input type="text" name="advantage[items][${advantageItemIndex}][note]" class="form-control" placeholder="Nhập ghi chú">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-danger removeAdvantageItemBtn"><i class="fa fa-trash"></i> Xóa</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', template);
        
        // Khởi tạo lại upload-image cho input mới
        const newItem = container.querySelector('.advantage-item:last-child');
        if (newItem) {
            const uploadInput = newItem.querySelector('.upload-image');
            if (uploadInput && typeof HT !== 'undefined' && typeof HT.upload === 'function') {
                HT.upload();
            }
        }
        
        advantageItemIndex++;
    });

    // Add Suitable Item
    document.getElementById('addSuitableItemBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        const container = document.getElementById('suitableItemsContainer');
        const template = `
            <div class="suitable-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px;">
                <div class="row mb15">
                    <div class="col-lg-3">
                        <div class="form-row">
                            <label class="control-label text-left">Ảnh</label>
                            <input type="text" name="suitable[items][${suitableItemIndex}][image]" class="form-control upload-image" placeholder="Chọn ảnh" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-row">
                            <label class="control-label text-left">Tên</label>
                            <input type="text" name="suitable[items][${suitableItemIndex}][name]" class="form-control" placeholder="Nhập tên">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-row">
                            <label class="control-label text-left">Mô tả</label>
                            <input type="text" name="suitable[items][${suitableItemIndex}][description]" class="form-control" placeholder="Nhập mô tả">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-row">
                            <label class="control-label text-left">&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm removeSuitableItemBtn" style="width: 100%;">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', template);
        suitableItemIndex++;
    });

    // Add Study Method Item
    document.getElementById('addStudyMethodItemBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        const container = document.getElementById('studyMethodItemsContainer');
        const template = `
            <div class="study-method-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px;">
                <div class="row mb15">
                    <div class="col-lg-3">
                        <div class="form-row">
                            <label class="control-label text-left">Ảnh</label>
                            <input type="text" name="study_method[items][${studyMethodItemIndex}][image]" class="form-control upload-image" placeholder="Chọn ảnh" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-row">
                            <label class="control-label text-left">Tên</label>
                            <input type="text" name="study_method[items][${studyMethodItemIndex}][name]" class="form-control" placeholder="Nhập tên">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-row">
                            <label class="control-label text-left">Mô tả</label>
                            <input type="text" name="study_method[items][${studyMethodItemIndex}][description]" class="form-control" placeholder="Nhập mô tả">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-row">
                            <label class="control-label text-left">&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm removeStudyMethodItemBtn" style="width: 100%;">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', template);
        studyMethodItemIndex++;
    });

    // Add Student Feedback
    document.getElementById('addStudentFeedbackBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        const container = document.getElementById('studentFeedbacksContainer');
        const template = `
            <div class="student-feedback-item mb15" data-feedback-index="${studentFeedbackIndex}">
                <div class="ibox" style="background: #f9f9f9; padding: 15px; border-radius: 5px;">
                    <div class="row mb15">
                        <div class="col-lg-3">
                            <div class="form-row">
                                <label class="control-label text-left">Ảnh đại diện</label>
                                <input type="text" name="feedback[items][${studentFeedbackIndex}][image]" class="form-control upload-image" placeholder="Chọn ảnh" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-row">
                                <label class="control-label text-left">Tên</label>
                                <input type="text" name="feedback[items][${studentFeedbackIndex}][name]" class="form-control" placeholder="Nhập tên">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-row">
                                <label class="control-label text-left">Chức vụ</label>
                                <input type="text" name="feedback[items][${studentFeedbackIndex}][position]" class="form-control" placeholder="Nhập chức vụ">
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-row">
                                <label class="control-label text-left">&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-sm removeStudentFeedbackBtn" style="width: 100%;">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-row">
                                <label class="control-label text-left">Mô tả</label>
                                <textarea name="feedback[items][${studentFeedbackIndex}][description]" class="form-control" rows="3" placeholder="Nhập mô tả"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', template);
        studentFeedbackIndex++;
    });

    // Add Degree Value Item
    document.getElementById('addDegreeValueItemBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        const container = document.getElementById('degreeValueItemsContainer');
        const template = `
            <div class="degree-value-item mb15" data-item-index="${degreeValueItemIndex}">
                <div class="ibox" style="background: #f9f9f9; padding: 15px; border-radius: 5px;">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-row">
                                <label class="control-label text-left">Icon</label>
                                <input type="text" name="value[items][${degreeValueItemIndex}][icon]" class="form-control upload-image" placeholder="Chọn icon" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-row">
                                <label class="control-label text-left">Tên giá trị</label>
                                <input type="text" name="value[items][${degreeValueItemIndex}][name]" class="form-control" placeholder="Nhập tên giá trị">
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-row">
                                <label class="control-label text-left">&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-sm removeDegreeValueItemBtn" style="width: 100%;">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', template);
        degreeValueItemIndex++;
    });

    // Remove handlers
    document.addEventListener('click', function(e) {
        if (e.target.closest('.removeAdvantageItemBtn')) {
            e.preventDefault();
            e.target.closest('.advantage-item').remove();
        }
        if (e.target.closest('.removeSuitableItemBtn')) {
            e.preventDefault();
            e.target.closest('.suitable-item').remove();
        }
        if (e.target.closest('.removeMajorItemBtn')) {
            e.preventDefault();
            const btn = $(e.target.closest('.removeMajorItemBtn'));
            const majorItem = btn.closest('.major-item');
            const majorId = majorItem.attr('data-major-id') || majorItem.data('major-id');
            
            if (majorId) {
                // Xóa khối major-item trước
                majorItem.remove();
                
                // Sau đó xóa khỏi select2
                const currentVal = $('#selected_major_ids').val() || [];
                const newVal = currentVal.filter(id => String(id) !== String(majorId));
                $('#selected_major_ids').val(newVal).trigger('change');
            }
        }
        if (e.target.closest('.removeStudyMethodItemBtn')) {
            e.preventDefault();
            e.target.closest('.study-method-item').remove();
        }
        if (e.target.closest('.removeStudentFeedbackBtn')) {
            e.preventDefault();
            e.target.closest('.student-feedback-item').remove();
        }
        if (e.target.closest('.removeDegreeValueItemBtn')) {
            e.preventDefault();
            e.target.closest('.degree-value-item').remove();
        }
    });

    // Switchery handler
    $(document).on('change', '.js-switch', function() {
        var hiddenInput = $(this).siblings('input[type="hidden"]');
        if (hiddenInput.length) {
            hiddenInput.val(this.checked ? 2 : 1);
        }
    });

    // Toggle collapse/expand
    document.querySelectorAll('.toggle-items-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const container = document.getElementById(targetId);
            const icon = this.querySelector('i');
            const text = this.querySelector('.toggle-text');
            
            if (container) {
                container.classList.toggle('collapsed');
                this.classList.toggle('collapsed');
                
                if (container.classList.contains('collapsed')) {
                    icon.className = 'fa fa-chevron-down';
                    text.textContent = 'Mở rộng';
                } else {
                    icon.className = 'fa fa-chevron-up';
                    text.textContent = 'Thu gọn';
                }
            }
        });
    });
});
</script>

