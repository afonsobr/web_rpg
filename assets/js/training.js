

async function training(trainingType) {
    showLoadingModal('Training in progress...');
    const result = await apiRequest('api/api_digimon', { action: 'trainPartner', trainingType: trainingType });

    setTimeout(() => {
        hideLoadingModal();
        showAlertModal(`<div class="text-lg pb-1"><b>Training Results</b></div>
        ${result.message}`,
            () => {
            })
    }, 1500);
}
