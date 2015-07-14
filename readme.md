# Ujian-Online
Code Source Ujian Online

Created by Vincent Gabriel
Modified By Abu Maryam aka Mohammad Aminudin - Agustus 2011
Modified by Eko Junaidi Salam - July 2015

# Langkah - langkah penggunaan :

- Buat Database Baru
- Eksekusi query pada file sql/tabel_saja.sql (bisa diimport atau eksekusi query/tab SQL pada phpmyadmin)
- Eksekusi query pada file sql/trigger.sql (tab SQL pada phpmyadmin)
- Eksekusi query pada file sql/view.sql (tab SQL pada phpmyadmin)
- Eksekusi query pada file sql/user.sql (tab SQL pada phpmyadmin)
- Edit file include/koneksi.php, sesuaikan nama host, username dan password database
- Edit file js/plugins/fmath_formula/dialogs/configMathMLEditor.xml, edit baris ke-24 sesuaikan urlnya
- Edit file js/plugins/fmath_formula/dialogs/editor.html (untuk mengatur lebar dan tinggi editor / biarkan juga gak papa)
- Edit file rumus_fmath/imageCapture.php baris ke-12 sesuaikan urlnya
- Edit file js/ckfinder/config.php, pada baris 66 berdasarkan nama folder anda, misal nama folder kita online_test maka $baseUrl = '/online_test/userfiles/';
- Untuk login admin gunakan Username : ekojs, Password : ekojs

Original URL : http://ameenlinuxer.blogspot.com/2015/07/source-code-ujian-online-berbasis-web.html


Original Bootstrap Admin Theme
===============================================================================================================================================================

Bootstrap Admin Theme [![Build Status](https://travis-ci.org/VinceG/Bootstrap-Admin-Theme.png?branch=master)](https://github.com/ekojs/Bootstrap-Admin-Theme-3)
=====================

##### If you are looking for the Admin theme designed for Bootstrap 3 please <a href='https://github.com/ekojs/Bootstrap-Admin-Theme-3' target="_blank">Click Here</a>


A generic admin theme built with Bootstrap free for both personal and commercial use. 

This is still a work in progress.

Pages:

- Login
- Admin Dashboard (Tables, Statistics, Chart, Media Gallery)
- Full Calendar (Viewing calendar, adding events, dragging events)
- Statistics & Charts (Multiple examples of Pie, Bar, Line charts using Morris.js, knob.js, jquery flot, easypiechart)
- Buttons & Icons
- WYSIWYG & HTML 5 Editors
- Forms & Wizard
- Tables & Bootstrap dataTables
- UI & Interface Elements (Modals, Popovers, Tooltips, Alerts, Notifications, Labels, Progress Bars)

Demo:
http://vinceg.github.com/Bootstrap-Admin-Theme

Created By :
<p>&copy; <a href='http://vadimg.com' target="_blank">Vadim Vincent Gabriel</a> <a href='https://twitter.com/gabrielva' target='_blank'>Follow @gabrielva</a> 2012</p>

License
===============
The MIT License (MIT)

Copyright (c) 2013 - Vincent Gabriel

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
