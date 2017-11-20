Args Module 
========================

Module writen in Symfony Framework based on "Clean Code. Robert C. Martin" exercise, chapter 14. Simple module to recognize and parse command-line arguments.  

#Usage
1. Provide schema and command into form
2. Module will generate below:

Command:
- -l true -p 234 -d Ala

Schema:
- l,p#,d*

After parse:
- letter: l, value: 1

- letter: p, value: 234

- letter: d, value: Ala
