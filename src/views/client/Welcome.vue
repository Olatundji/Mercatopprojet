<!-- eslint-disable vue/multi-word-component-names -->

<template>
    <CRow class="custom">
        <CCol :md="3">
            +229 68685949
        </CCol>
        <CCol :md="3">
            MERCATO
        </CCol>
        <CCol :md="3">
            Panier
        </CCol>
        <CCol :md="3">
            <CForm class="d-flex">
                <CFormInput type="search" class="me-2" placeholder="Search" />
                <CButton type="submit" color="success" variant="outline">Chercher</CButton>
            </CForm>
        </CCol>
        <hr class="diviser" >
    </CRow>
    
</template>
<script>
export default {
    data() {
        return {
            tabPaneActiveKey: 1,
        }
    }
}
</script>

<style scoped>
.diviser {
    line-height: 1em;
    position: relative;
    outline: 0;
    border: 0;
    color: black;
    text-align: center;
    height: 1.5em;
    opacity: .5;

    &:before {
        content: '';
        background: linear-gradient(to right, transparent, #818078, transparent);
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
    }

    &:after {
        content: attr(data-content);
        position: relative;
        display: inline-block;
        color: black;

        padding: 0 .5em;
        line-height: 1.5em;
        color: #818078;
        background-color: #fcfcfa;
    }
}

.custom {
    padding: 10px;
}
</style>