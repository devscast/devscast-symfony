window.addEventListener('scroll', () => {
    if (window.pageYOffset > 1000) {
        document.getElementById('expertises').scrollBy({
            top: window.pageYOffset / 6,
            behavior: 'smooth',
        });
    } else {
        document.getElementById('expertises').scrollBy({
            top: -(window.pageYOffset / 6),
            behavior: 'smooth',
        });
    }
})

const sidebar = document.querySelector("#links");
const sbOpen = document.querySelector("#sbOpen");
const sbDismiss = document.querySelector("#sbDismiss");
const sfLauncher = document.querySelector("#sfLauncher");
const sForm = document.querySelector("#sForm");

sbOpen.addEventListener('click', () => {
    sidebar.classList.remove('hidden', '-ml-all');
    sbOpen.classList.add('hidden');
    sbDismiss.classList.remove('hidden');
    document.querySelector('body').classList.add('overflow-y-hidden');
});

sbDismiss.addEventListener('click', () => {
    sidebar.classList.add('-ml-all');
    sbOpen.classList.remove('hidden');
    sbDismiss.classList.add('hidden');
    document.querySelector('body').classList.remove('overflow-y-hidden');
});

sfLauncher.addEventListener('click', () => {
    sForm.classList.remove('lg:hidden');
    sForm.classList.remove('lg:-mr-10');
    sfLauncher.classList.remove('lg:block');
})
