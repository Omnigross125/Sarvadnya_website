document.getElementById('oneToOneBtn').addEventListener('click', function() {
    document.getElementById('oneToOne').classList.add('active');
    document.getElementById('group').classList.remove('active');
    this.classList.add('active');
    document.getElementById('groupBtn').classList.remove('active');
});

document.getElementById('groupBtn').addEventListener('click', function() {
    document.getElementById('group').classList.add('active');
    document.getElementById('oneToOne').classList.remove('active');
    this.classList.add('active');
    document.getElementById('oneToOneBtn').classList.remove('active');
});