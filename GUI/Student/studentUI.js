let sidebar = document.querySelector('.sidebar');
let listItem = document.querySelectorAll('.list-item');
let content = document.querySelector('.content');
let btn = document.querySelector('#btn');

btn.onclick = function() {
    content.classList.toggle('active');
    sidebar.classList.toggle('active');
}

function activeLink() {
    listItem.forEach(item =>
        item.classList.remove('active')
    );

    this.classList.add('active');
}

listItem.forEach(item =>
    item.onclick = activeLink
);

function login() {
    document.getElementById('logoutForm').submit();
}


function saveTab(tabName) {
	var form_data = new FormData();

	form_data.append('currentTab', tabName);

	var ajax_request = new XMLHttpRequest();

	ajax_request.open('POST', 'studentUI.php');
	ajax_request.send(form_data);
}

// MARK: - Open Tab
function openTab(tabName) {
    var i, x;
    x = document.getElementsByClassName("tab");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }

    document.getElementById(tabName).style.display = "block";
    saveTab(tabName);
}