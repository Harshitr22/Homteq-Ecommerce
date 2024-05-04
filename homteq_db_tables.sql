DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS Order_Line;

CREATE TABLE Product 
(
    prodId  INTEGER not null AUTO_INCREMENT,
    prodName VARCHAR(200) not null,
    prodPicNameSmall VARCHAR(200) not null,
    prodPicNameLarge VARCHAR(200) NULL,
    prodDescripShort VARCHAR(1000) NULL,
    prodDescripLong VARCHAR(3000),
    prodPrice DECIMAL(8,2) not null,
    prodQuantity INT,
    constraint p_pid_pk PRIMARY KEY(prodId)
);

INSERT INTO 
Product (prodName, prodPicNameSmall, prodPicNameLarge, prodDescripShort, prodDescripLong, prodPrice, prodQuantity)
VALUES
( 'Echo Dot', 'Echodot.png', 'echodotbig.png', 'Our most popular smart speaker 
features a sleek design and improved audio for vibrant sound anywhere in your home. 
With Echo Dot, you can stay on track with help from Alexa and control compatible smart
 home devices.', 'OUR BEST-SOUNDING ECHO DOT YET - Enjoy an improved audio experience compared to any previous Echo Dot.
 YOUR FAVOURITE MUSIC AND CONTENT - Play music, audiobooks and podcasts from Amazon Music, Apple Music, Spotify,etc. 
 ALEXA IS HAPPY TO HELP - Ask Alexa for the weather forecast, to set hands-free timers, get answers to your questions and even tell jokes.
 KEEP YOUR HOME COMFORTABLE - Control compatible smart home devices with your voice and routines triggered by indoor temperature. 
 EERO BUILT-IN – Turn your Echo device into a Wi-Fi extender in minutes with compatible Echo and eero devices.
 CLIMATE PLEDGE FRIENDLY - We integrated sustainability in the design of this device with 99% of packaging coming from responsibly managed forests or recycled sources.',
 54.99, 12),

 ( 'Apple Watch Series 9 [41mm]', 'applewatch.png', 'applewatchbig.png', 'Apple Watch Series 9 [GPS 41mm] Smartwatch with Midnight Aluminum Case with Midnight Sport Band S/M. Fitness Tracker, Blood Oxygen & ECG Apps, Always-On Retina Display, Water Resistant',
 'CELLULAR CONNECTIVITY — Send a text, make a call and stream music without your iPhone nearby.
 ADVANCED HEALTH FEATURES — Keep an eye on your blood oxygen. Take an ECG anytime. Get notifications if you have an irregular heart rhythm
 A POWERFUL FITNESS PARTNER — The Workout app gives you a range of ways to train plus advanced metrics for more insights about your workout performance.
 INNOVATIVE SAFETY FEATURES — Fall Detection and Crash Detection can connect you with emergency services in the event of a hard fall or a serious car crash.
 SIMPLY COMPATIBLE — It works seamlessly with your Apple devices and services. Unlock your Mac automatically.
 EASILY CUSTOMISABLE — With watch straps in a range of styles, materials and colours and fully customisable watch faces.
 INCREDIBLE DURABILITY — Tougher than tough. It’s crack resistant, IP6X-certified dust resistant, and swimproof with 50m water resistance.', 340.00, 8),

( 'Bose QuietComfort HeadPhones', 'headphone.png', 'headphonesbig.png', 'Customisable legendary noise cancelling, comfortable fit, adjustable EQ, and striking colours - all in one pair of iconic headphones. Go beyond the beat with sound that puts you on top of the world.',
'LEGENDARY NOISE CANCELLATION: Effortlessly combines noise cancelling headphone technology with passive features.
PREMIUM COMFORT: Plush earcup cushions softly hug your ears.
TWO LISTENING MODES: These wireless Bluetooth headphones feature Quiet and Aware Modes that let you toggle.
HIGH-FIDELITY AUDIO/EQ CONTROL: Supercharge your favourite tracks with high-fidelity audio and Adjustable EQ.
ALL-DAY BATTERY LIFE: Bose QuietComfort wireless headphones provide up to 24 hours of battery on a single charge.
STAYS CONNECTED TO YOUR DEVICES: Seamlessly stay connected to all your favourite devices.', 299.95, 4),

('reMarkable Tablet', 'remarkable.png', 'remarkablebig.png','Replace your notebooks and printouts with the only tablet that feels like paper. All your handwritten notes, to-dos, PDFs, and ebooks, perfectly organized and in one place.',
'THE ONLY TABLET THAT FEELS LIKE PAPER: Meet the paper tablet that redefines note-taking, reading, and reviewing documents, with a paper feel.
ALL YOUR NOTES ORGANIZED AND ACCESSIBLE: Keep all your handwritten notes, to-do lists, PDFs, ebooks, and sketches organized and in one place. reMarkable bridges the gap.
DESIGNED TO HELP YOU FOCUS: Distraction-free by design.
HANDWRITING CONVERSION AND CLOUS STORAGE: Make your handwritten notes easy to reuse by converting them into typed text and share via email.
', 279.00, 20);



CREATE TABLE Users
(
    userId INTEGER not null AUTO_INCREMENT,
    userType VARCHAR(20) not null,
    userFname VARCHAR(100) not null,
    userSname VARCHAR(100) not null, 
    userAddress VARCHAR(200) not null, 
    userPostCode VARCHAR(20) not null,
    userTelNo VARCHAR(100) not null, 
    userEmail VARCHAR(100) not null UNIQUE,
    userPassword VARCHAR(100) not null, 
    constraint u_urid_pk PRIMARY KEY(userId)
);

INSERT INTO 
Users (userType, userFname, userSname, userAddress, userPostCode, userTelNo, userEmail, userPassword)
VALUES
('Admin', 'Harshit', 'Raj', '11 Hollywood Gardens', 'UB4 0DX', '07424881667', 'w1915214@my.westminster.ac.uk', 'Harshitraj2212'),
('Customer', 'Mitul', 'Arora', '7 Demon Avenue', 'HELL 101', '09876543211', 'mitularora07@demon.com', 'mitularorac'),
('Customer', 'Sirirath', 'Samith', '9 Hell Paradise', 'HELL 101', '09988776655', 'sirisamith@demonchild.com', 'sirisamithc'),
('Customer', 'Random', 'Person', '90 Somewhere someplace', 'D0NT KN0', '07766550099', 'maybeIam@god.com', 'randompersonc');


CREATE TABLE Orders
(
    orderNo INTEGER not null AUTO_INCREMENT,
    userId INTEGER not null,
    orderDateTime DATE not null, 
    orderTotal DECIMAL (8,2) not null DEFAULT 0.00, 
    orderStatus VARCHAR(50) null, 
    shippingDate DATE null, 
    constraint o_ordnb_pk PRIMARY KEY(orderNo),
    constraint o_urid_fk FOREIGN KEY(userId) references Users(userId) ON DELETE CASCADE
);

CREATE TABLE Order_Line
(
    orderLineId INTEGER not null AUTO_INCREMENT,
    orderNo INTEGER not null,
    prodId INTEGER not null, 
    quantityOrdered INTEGER not null, 
    subTotal DECIMAL (8,2) not null DEFAULT 0.00,
    constraint ol_olid_pk PRIMARY KEY(orderLineId),
    constraint ol_ordnb_pk FOREIGN KEY(orderNo) references Orders(orderNo) ON DELETE CASCADE,
    constraint ol_pid_fk FOREIGN KEY(prodId) references Product(prodId) ON DELETE CASCADE
);