//const state = { 'page_id': 1, 'user_id': 5 }
//const url = 'hello-world.html'

//history.pushState(state, '', url)


function active_00(){
    var element = document.getElementById("test2");
    element.classList.remove("active");
    var element = document.getElementById("test1");
    element.classList.add("active");
}

function active_01(){
    var element = document.getElementById("test1");
    element.classList.remove("active");
    var element = document.getElementById("test2");
    element.classList.add("active");
}

function active(){
    // 1. tangkap element dengan class menu
    const menu = document.querySelector(".menu");

    // 2. jika element dengan class menu diklik
    menu.addEventListener('click', function(e) 
    {
        // 3. maka ambil element apa yang diklik oleh user
        const targetMenu = e.target;

        // 4. lalu cek, jika element itu adalah link dengan class menu__link
        if(targetMenu.classList.contains('sidebar-link')) {
                
            // 5. maka ambil menu link yang aktif
            const menuLinkActive = document.querySelector("ul li a.active1");

            // 6. lalu cek, Jika menu link active ada dan menu yang di klik user adalah menu yang tidak sama dengan menu yang aktif, (cara cek-nya yaitu dengan membandingkan value attribute href-nya)
            if(menuLinkActive !== null && targetMenu.getAttribute('href') !== menuLinkActive.getAttribute('href')) {

                // 7. maka hapus class active pada menu yang sedang aktif
                menuLinkActive.classList.remove('active1');
            }

            // 8. terakhir tambahkan class active pada menu yang di klik oleh user
            targetMenu.classList.add('active1');
        }
    });
}