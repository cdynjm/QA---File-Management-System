const vueHeader = new Vue({
    el: '.header',
    data: { 
        
        headerLabel: 'QA File Management System',
        accountType1: 'ADMIN',
        accountType2: 'USER',
    }
})
const vueSidebar = new Vue({
    el: '.sidebar',
    data: { 
        sidebarLabel: 'SLSU',
        sidebarBTN1: 'Dashboard',
        sidebarBTN2: 'Log Out',
    }
})
const vueSubHeader = new Vue({
    el: '.sub-header',
    data: { 

        searchFilter: 'Filter Result: ',

        option1: 'Document Title',
        option2: 'Description',
        option3: 'Date',
        option4: 'Keywords',

        subHeaderLabel1: 'Upload File',
        subHeaderLabel2: 'New Folder',
        subHeaderLabel3: 'Print',
    }
})
const vueUpload = new Vue({
    el: '.upload-pop-up',
    data: { 
        uploadHeader: 'Upload New File',
        uploadLabel1: 'Document Title',
        uploadLabel2: 'Description',
        uploadLabel3: 'Date',
        uploadLabel4: 'Keywords',
        uploadLabel5: 'Upload File',
    }
})

const vueFolder = new Vue({
    el: '.new-folder',
    data: { 
        folderHeader: 'Create New Folder',
        folderLabel: 'Folder Name',
        folderCreate: 'Create',
        folderCancel: 'Cancel',
    }
})
