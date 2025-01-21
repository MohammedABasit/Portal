$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const trainerId = urlParams.get('id');
    
    if (!trainerId) {
        window.location.href = 'trainers.php';
        return;
    }

    $('.loader-container').show();
    
    fetch(`API/Trainers/get_trainer_details.php?id=${trainerId}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                renderTrainerDetails(result.data);
            } else {
                throw new Error(result.message);
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: error.message
            });
        })
        .finally(() => {
            $('.loader-container').hide();
        });
});

function renderTrainerDetails(trainer) {
    const detailsHtml = `
        <div class="row">
            <div class="col-md-3 text-center mb-4">
                <img src="${trainer.profile_photo ? 'uploads/' + trainer.profile_photo : 'assets/img/Default.jpg'}"
                     alt="${trainer.full_name}"
                     class="img-fluid rounded-circle mb-3"
                     style="max-width: 200px;">
                <h4>${trainer.full_name}</h4>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5>معلومات شخصية</h5>
                        <table class="table">
                            <tr>
                                <th>الرقم الوطني:</th>
                                <td>${trainer.national_id}</td>
                            </tr>
                            <tr>
                                <th>النوع:</th>
                                <td>${trainer.gender_name}</td>
                            </tr>
                            <tr>
                                <th>تاريخ الميلاد:</th>
                                <td>${trainer.birthdate}</td>
                            </tr>
                            <tr>
                                <th>العنوان:</th>
                                <td>${trainer.address}</td>
                            </tr>
                            <tr>
                                <th>الموطن الأصلي:</th>
                                <td>${trainer.origin_place}</td>
                            </tr>
                            <tr>
                                <th>الحالة الاجتماعية:</th>
                                <td>${trainer.marital_status_name}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5>معلومات العائلة</h5>
                        <table class="table">
                            <tr>
                                <th>اسم الوالد:</th>
                                    <td>${trainer.father_name} ${trainer.father_alive ? '<span class="badge rounded-pill bg-secondary">على قيد الحياة</span>' : '<span class="badge rounded-pill bg-danger">متوفي</span>'}</td>
                                </tr>
                                <tr>
                                    <th>اسم الوالدة:</th>
                                    <td>${trainer.mother_name} ${trainer.mother_alive ? '<span class="badge rounded-pill bg-secondary">على قيد الحياة</span>' : '<span class="badge rounded-pill bg-danger">متوفية</span>'}</td>
                                </tr>
                            ${trainer.marital_status > 1 ? `
                            <tr>
                                <th>عدد الزوجات:</th>
                                <td>${trainer.wifes_count || 0}</td>
                            </tr>
                            <tr>
                                <th>عدد الأطفال:</th>
                                <td>${trainer.children_count || 0}</td>
                            </tr>
                            ` : ''}
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 mb-4">
                        <h5>المؤهلات الأكاديمية</h5>
                        ${renderAcademicHistory(trainer.academic_history)}
                    </div>
                    
                    <div class="col-12 mb-4">
                        <h5>الخبرات العملية</h5>
                        ${renderExperience(trainer.experience)}
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <h5>المهارات</h5>
                        ${renderSkills(trainer.skills)}
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <h5>الهوايات</h5>
                        ${renderHobbies(trainer.hobbies)}
                    </div>
                    
                    <div class="col-12 mb-4">
                        <h5>الصحة والرياضة</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p>الحالة الصحية العامة: ${trainer.health_status}%</p>
                                <p>مستوى الصحة النفسية: ${trainer.mental_health}/5</p>
                                ${trainer.previous_illness ? `
                                <p>الأمراض السابقة: ${trainer.previous_illness}</p>
                                ` : ''}
                            </div>
                            <div class="col-md-6">
                                <h6>الأمراض المزمنة:</h6>
                                ${renderIllnesses(trainer.illnesses)}
                                <h6 class="mt-2 mb-1">الممارسات الرياضية:</h6>
                                ${renderSports(trainer.sports)}
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <h5>المرفقات</h5>
                        <div class="list-group">
                            ${renderAttachment('السيرة الذاتية', trainer.cv_file)}
                            ${renderAttachment('الشهادات', trainer.certificates)}
                            ${renderAttachment('مرفقات أخرى', trainer.other_attachments)}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#trainerDetails').html(detailsHtml);
}

function renderAttachment(title, files) {
    if (!files) return '';

    const fileList = files.split(',').map(file => file.trim()).filter(file => file);
    
    if (fileList.length === 0) return '';

    return fileList.map((file, index) => `
        <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <span>${title} ${fileList.length > 1 ? (index + 1) : ''}</span>
                <div class="btn-group">
                    <a href="uploads/${file}" class="btn btn-primary btn-sm" target="_blank">
                        <i class="bi bi-eye"></i> عرض
                    </a>
                    <a href="uploads/${file}" class="btn btn-secondary btn-sm" download>
                        <i class="bi bi-download"></i> تحميل
                    </a>
                </div>
            </div>
        </div>
    `).join('');
}

function renderAcademicHistory(history) {
    if (!history || history.length === 0) {
        return '<p>لا توجد مؤهلات مسجلة</p>';
    }
    
    return `
        <table class="table">
            <thead>
                <tr>
                    <th>المؤسسة</th>
                    <th>التخصص</th>
                    <th>الدرجة</th>
                    <th>سنة التخرج</th>
                </tr>
            </thead>
            <tbody>
                ${history.map(item => `
                    <tr>
                        <td>${item.institution}</td>
                        <td>${item.major}</td>
                        <td>${item.degree_name}</td>
                        <td>${item.graduation_year}</td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
}

function renderExperience(experience) {
    if (!experience || experience.length === 0) {
        return '<p>لا توجد خبرات مسجلة</p>';
    }
    
    return `
        <table class="table">
            <thead>
                <tr>
                    <th>المؤسسة</th>
                    <th>الوظيفة</th>
                    <th>المدة (بالأشهر)</th>
                    <th>تاريخ الانتهاء</th>
                </tr>
            </thead>
            <tbody>
                ${experience.map(item => `
                    <tr>
                        <td>${item.institution}</td>
                        <td>${item.job}</td>
                        <td>${item.duration}</td>
                        <td>${item.working ? 'حتى الآن' : item.date_end} </td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
}

function renderSkills(skills) {
    if (!skills || skills.length === 0) {
        return '<p>لا توجد مهارات مسجلة</p>';
    }
    
    return `
        <ul class="list-group">
            ${skills.map(item => `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${item.skill_name}
                    <span class="badge bg-primary rounded-pill">${item.skill_level}/5</span>
                </li>
            `).join('')}
        </ul>
    `;
}

function renderHobbies(hobbies) {
    if (!hobbies || hobbies.length === 0) {
        return '<p>لا توجد هوايات مسجلة</p>';
    }
    
    return `
        <ul class="list-group">
            ${hobbies.map(item => `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${item.hobby_name}
                    <span class="badge bg-primary rounded-pill">${item.proficiency_level}/5</span>
                </li>
            `).join('')}
        </ul>
    `;
}

function renderIllnesses(illnesses) {
    if (!illnesses || illnesses.length === 0) {
        return '<p>لا توجد أمراض مزمنة مسجلة</p>';
    }
    
    return `
        <ul class="list-group">
            ${illnesses.map(item => `
                <li class="list-group-item">
                    ${item.illness_type}
                    <small class="text-muted d-block">منذ: ${item.start_date}</small>
                </li>
            `).join('')}
        </ul>
    `;
}

function renderSports(sports) {
    if (!sports || sports.length === 0) {
        return '<p>لا توجد ممارسات رياضية مسجلة</p>';
    }
    
    return `
        <ul class="list-group">
            ${sports.map(item => `
                <li class="list-group-item d-flex justify-content-between align-items-center mt-1">
                    ${item.sport_type}
                    <span class="badge bg-secondary">${item.routine}</span>
                </li>
            `).join('')}
        </ul>
    `;
}