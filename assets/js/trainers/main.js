document.addEventListener('DOMContentLoaded', function() {
    const viewSwitcher = new ViewSwitcher();
    const trainersRenderer = new TrainersRenderer();
    
    // Initial load
    trainersRenderer.fetchTrainers();
    
    // Refresh button handler
    document.getElementById('refreshBtn').addEventListener('click', () => {
        trainersRenderer.fetchTrainers();
    });
    
    // View trainer details handler
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('view-trainer')) {
            const trainerId = e.target.dataset.id;
            // Handle viewing trainer details (implement as needed)
            console.log('View trainer:', trainerId);
        }
    });
});