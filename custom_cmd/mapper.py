import sys

for line in sys.stdin:
	line = line.strip()
	words = line.split(',')
	i=0
	for word in words:
		if i%2==0:
			print '%s\t%s' % (word,words[1])
			i=i+1