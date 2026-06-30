import re

with open(r'c:\laragon\www\skpi\resources\views\mahasiswa\dashboard.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace("@extends('layouts.app')", "@extends('layout.main')")
content = content.replace('<div class="space-y-6">', '<div class="row g-5 g-xl-10 mb-5 mb-xl-10">')
content = content.replace('<div class="card overflow-hidden animate-fade-in">', '<div class="col-12"><div class="card overflow-hidden">')
# Close the col-12 div after the first card
# This might be tricky with regex, so let's just do targeted replaces.

with open(r'c:\laragon\www\skpi\resources\views\mahasiswa\dashboard.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
