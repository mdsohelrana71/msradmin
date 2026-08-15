<div class="custom-template">
    <div class="title">Settings</div>
    <div class="custom-content">
        <div class="switcher">

            {{-- Logo Header --}}
            <div class="switch-block">
                <h4>Logo Header</h4>
                <div class="btnSwitch">
                    @php
                        $logoHeaderColor = $settings->logo_header_color ?? 'dark';
                        $logoColors = ['dark', 'blue', 'purple', 'light-blue', 'green', 'orange', 'red', 'white', 'dark2', 'blue2', 'purple2', 'light-blue2', 'green2', 'orange2', 'red2'];
                    @endphp

                    @foreach($logoColors as $color)
                        <button type="button"
                            class="{{ $logoHeaderColor === $color ? 'selected' : '' }} changeLogoHeaderColor"
                            data-color="{{ $color }}">
                        </button>
                        @if($color === 'white')
                            <br />
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Navbar Header --}}
            <div class="switch-block">
                <h4>Navbar Header</h4>
                <div class="btnSwitch">
                    @php
                        $topbarColor = $settings->topbar_color ?? 'white';
                        $topbarColors = ['dark', 'blue', 'purple', 'light-blue', 'green', 'orange', 'red', 'white', 'dark2', 'blue2', 'purple2', 'light-blue2', 'green2', 'orange2', 'red2'];
                    @endphp

                    @foreach($topbarColors as $color)
                        <button type="button"
                            class="{{ $topbarColor === $color ? 'selected' : '' }} changeTopBarColor"
                            data-color="{{ $color }}">
                        </button>
                        @if($color === 'white')
                            <br />
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="switch-block">
                <h4>Sidebar</h4>
                <div class="btnSwitch">
                    @php
                        $sidebarColor = $settings->sidebar_color ?? 'dark';
                        $sidebarColors = ['white', 'dark', 'dark2'];
                    @endphp

                    @foreach($sidebarColors as $color)
                        <button type="button"
                            class="{{ $sidebarColor === $color ? 'selected' : '' }} changeSideBarColor"
                            data-color="{{ $color }}">
                        </button>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
    <div class="custom-toggle">
        <i class="icon-settings"></i>
    </div>
</div>