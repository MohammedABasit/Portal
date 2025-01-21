class ViewSwitcher {
    constructor() {
        this.currentView = 'table';
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        document.getElementById('viewToggle').addEventListener('change', (e) => {
            this.currentView = e.target.checked ? 'grid' : 'table';
            this.toggleView();
        });
    }

    toggleView() {
        const tableView = document.getElementById('tableView');
        const gridView = document.getElementById('gridView');

        if (this.currentView === 'grid') {
            tableView.style.display = 'none';
            gridView.style.display = 'block';
        } else {
            tableView.style.display = 'block';
            gridView.style.display = 'none';
        }
    }
}