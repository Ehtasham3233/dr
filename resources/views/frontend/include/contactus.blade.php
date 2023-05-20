            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="contact-form">
                <form method="POST" id="form-contact" action="{{ url('contact_us/store') }}"> @csrf            
                <div class="contact-input">
                    <label>Name *</label>
                    <input type="text" name="name" placeholder="Name" required="true" value="">                
                </div>
                <div class="contact-input">
                    <label>Email *</label>
                    <input type="email" name="email" placeholder="Email" required="true" value="">                
                </div>
                <div class="contact-input">
                    <label>Subject *</label>
                    <input type="text" name="subject" placeholder="Subject" required="true" value="">                
                </div>
                <div class="contact-input">
                    <label>Body *</label>
                    <textarea name="body" placeholder="Body" required="true"></textarea> 
                </div>
                <div class="contact-input">
                    <label></label>
                    <button type="submit">Submit</button>                
                </div>
                </form>
            </div>