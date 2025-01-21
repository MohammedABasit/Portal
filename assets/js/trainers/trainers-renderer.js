class TrainersRenderer {
    constructor() {
        this.trainers = [];
        this.loaderContainer = document.querySelector('.loader-container');
    }

    showLoader() {
        this.loaderContainer.style.display = 'block';
    }

    hideLoader() {
        this.loaderContainer.style.display = 'none';
    }

    async fetchTrainers() {
        this.showLoader();
        try {
            const response = await fetch('API/Trainers/get_trainers.php');
            const result = await response.json();
            
            if (result.success) {
                this.trainers = result.data;
                this.renderBothViews();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: error.message || 'حدث خطأ في تحميل البيانات'
            });
        } finally{
            this.hideLoader();
        }
    }

    renderBothViews() {
        this.renderTableView();
        this.renderGridView();
    }

    renderTableView() {
        const tbody = document.querySelector('#tableView tbody');
        tbody.innerHTML = this.trainers.map(trainer => `
            <tr>
                <td>
                    <img src="${trainer.profile_photo ? `uploads/${trainer.profile_photo}` : 'assets/img/Default.jpg'}"
                         alt="${trainer.full_name}" 
                         class="rounded-circle"
                         width="40" 
                         height="40">
                </td>
                <td>${trainer.full_name}</td>
                <td>${trainer.national_id}</td>
                <td>${trainer.gender}</td>
                <td>${trainer.birthdate}</td>
                <td>${trainer.address}</td>
                <td>
                    <div class="btn-group">
                        <a href="trainer-details.php?id=${trainer.id}" 
                            class="btn btn-sm btn-primary">عرض</a>
                        <button class="btn btn-sm btn-danger delete-trainer" 
                                data-id="${trainer.id}">حذف</button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    renderGridView() {
        const grid = document.getElementById('gridView');
        grid.innerHTML = `
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                ${this.trainers.map(trainer => `
                    <div class="col">
                        <div class="card h-100 trainer-card">
                            <div class="card-body d-flex flex-column align-items-center">
                                <div class="trainer-image-wrapper mb-3">
                                    <img src="${trainer.profile_photo ? `uploads/${trainer.profile_photo}` : 'assets/img/default.jpg'}" 
                                         alt="${trainer.full_name}" 
                                         class="rounded-circle trainer-image">
                                </div>
                                <h5 class="card-title text-center mb-2">${trainer.full_name}</h5>
                                <p class="card-text text-center mb-3">
                                    ${trainer.address}<br>
                                    <small class="text-muted">${trainer.national_id}</small>
                                </p>
                                <a class="btn btn-primary mt-auto view-trainer" href="trainer-details.php?id=${trainer.id}">
                                    عرض
                                </a>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>`;
    }
}