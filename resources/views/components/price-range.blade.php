    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.css">
    <link rel="stylesheet" href="{{ asset('components/css/price-range.css') }}">

    <div class="slider-container">

            <div class="slider-inputs">

                <div>
                    <label for="price-min">Preço Mínimo:</label>
                    <input type="number" id="price-min" name="price-min" value="119" min="0" max="1000">
                </div>

                <div>
                    <label for="price-max">Preço Máximo:</label>
                    <input type="number" id="price-max" name="price-max" value="800" min="0" max="1000">
                </div>

                <div id="price-slider"></div>

                <button class="submit-btn" id="submit_btn">Filtrar</button>
            </div>
        </form>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.js"></script>
    <script src="{{asset('components/js/price-range.js')}}"></script>
    </body>