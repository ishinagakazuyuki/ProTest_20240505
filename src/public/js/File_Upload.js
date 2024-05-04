function dragOverHandler(event) {
    event.preventDefault();
    event.dataTransfer.dropEffect = 'copy';
    document.getElementById('drop-area').classList.add('dragover');
}

function dragLeaveHandler(event) {
    event.preventDefault();
    document.getElementById('drop-area').classList.remove('dragover');
}

function dropHandler(event) {
    event.preventDefault();
    document.getElementById('drop-area').classList.remove('dragover');
    var files = event.dataTransfer.files;
    handleFiles(files);
}

function handleFileSelect(event) {
    var files = event.target.files;
    handleFiles(files);
}

function handleFiles(files) {
    for (var i = 0; i < files.length; i++) {
        uploadFile(files[i]);
    }
}

function uploadFile(file) {
    var formData = new FormData();
    formData.append('file', file);

    fetch('/upload', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
        .then(response => {
            if (response.ok) {
                console.log('File uploaded successfully.');
            } else {
                console.error('File upload failed.');
            }
        })
        .catch(error => {
            console.error('Error uploading file:', error);
        });
}