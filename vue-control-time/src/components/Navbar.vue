<template>
    <mdb-navbar color="primary" dark>
        <router-link to="/">
            <mdb-navbar-brand href="/">
                ControlTime
            </mdb-navbar-brand>
        </router-link>
        <mdb-navbar-toggler>
            <mdb-dropdown tag="li" class="nav-item">
                <mdb-dropdown-toggle tag="a" navLink color="gray" slot="toggle" waves-fixed>Сотрудники</mdb-dropdown-toggle>
                <mdb-dropdown-menu>

                    <router-link to="/workers/all" tag="li">
                        <mdb-dropdown-item>
                            Список
                        </mdb-dropdown-item>
                    </router-link>

                    <router-link to="/workers/create" tag="li">
                        <mdb-dropdown-item>
                            Добавить
                        </mdb-dropdown-item>
                    </router-link>

                </mdb-dropdown-menu>
            </mdb-dropdown>

            <mdb-dropdown tag="li" class="nav-item">
                <mdb-dropdown-toggle tag="a" navLink color="gray" slot="toggle" waves-fixed>Посещения</mdb-dropdown-toggle>
                <mdb-dropdown-menu>

                    <router-link to="/times/all" tag="li">
                        <mdb-dropdown-item>
                            Список
                        </mdb-dropdown-item>
                    </router-link>

                </mdb-dropdown-menu>
            </mdb-dropdown>
            <form>
                <mdb-input type="text" class="text-white" placeholder="Search" aria-label="Search" label navInput waves waves-fixed/>
            </form>
        </mdb-navbar-toggler>
    </mdb-navbar>
</template>

<script>
    import { mdbNavbar, mdbNavbarBrand, mdbNavbarToggler, mdbNavbarNav, mdbNavItem, mdbDropdown, mdbDropdownMenu, mdbDropdownToggle, mdbInput, mdbDropdownItem } from 'mdbvue';
    export default {
        name: 'NavbarPage',
        components: {
            mdbNavbar,
            mdbNavbarBrand,
            mdbNavbarToggler,
            mdbNavbarNav,
            mdbNavItem,
            mdbDropdown,
            mdbDropdownMenu,
            mdbDropdownToggle,
            mdbDropdownItem,
            mdbInput
        }
    }
</script>

<style lang="scss" scoped>

</style>
