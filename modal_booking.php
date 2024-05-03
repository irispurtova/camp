<div class="modal" id="myModal">
    <div class="modal-content">
        <span class="close" onclick="closeBookingModal()">&times;</span>
        <h2></h2>
        <p id="modalContent">Содержимое модального окна</p>

        <div class="modal-in">
            <div class="title">Телефон</div>
            <input type="tel" id="tel" required
                placeholder="8 123 456 7890"
                pattern="8-[0-9]{3}-[0-9]{3}-[0-9]{4}">
        </div>

        <div class="modal-in">
            <div class="title">email</div>
            <input type="email" id="email" name="email" required
                placeholder="Электронная почта">
        </div>

        <div class="modal-in">
            <div class="title">Имя родителя</div>
            <input type="text" id="nameParent" required
                placeholder="Введите имя родителя">
        </div>

        <hr>

        <div class="modal-in">
            <div class="title">Имя ребенка</div>
            <input type="text" id="nameChild" required
                placeholder="Введите имя ребенка">
        </div>

        <div class="modal-in">
            <div class="title">Возраст ребенка</div>
            <input type="number" id="childAge" required
                placeholder="Введите возраст ребенка" min='3'>
        </div>
        
        <button class="booking" onclick="submitBooking(event)">ЗАБРОНИРОВАТЬ</button>
    </div>
</div>