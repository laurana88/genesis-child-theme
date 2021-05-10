const nav = document.getElementById("genesis-nav-primary");
const searchIcon = document.querySelector("li.menu-item.search");
const popup = document.getElementsByClassName("laura_search_popup_box");
const searchForm = document.getElementsByClassName("search-form");
const searchInput = document.getElementsByClassName("search-form-input");

// open search
const searchSite = (event) =>  {
    popup[0].style.display = "table";
    searchForm[0].style.display = "block";
    searchInput[0].focus();
};

// close search
const closeSearch = (event) => {
    const target = event.target;
    if (searchForm[0] !== target && searchInput[0] !== target) {
        popup[0].style.display = '';
        searchForm[0].style.display = '';
    }
}

searchIcon.addEventListener("click", searchSite);
popup[0].addEventListener("click", closeSearch);

