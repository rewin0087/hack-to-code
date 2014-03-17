def palindrum (word)
	n = word
	rev = n.reverse
	
	if n == rev
	  puts "palindrum"
	else
	  puts "not a palindrum"
	end
	
	puts "word is " + rev
end

def fibonacci (n)
	first_number = 0
	second_number = 1
	total = 0
	
	for i in 1...n
		total = first_number + second_number
		first_number = second_number
		second_number = total
	end
	
	puts total
end

def pigLatin(word)
	alpha = ('a'..'z').to_a
	vowels = %w[a e i o u]
	consonants = alpha - vowels

	w = ""
	if vowels.include?(word[0]) && word[1] == word[2]
		w = word[2..-1] + word[0..0] + 'way'
	elsif vowels.include?(word[0])
		w = word[1..-1] + word[0..0] + 'way'
	elsif consonants.include?(word[0]) && 
		consonants.include?(word[1])
		w = word[2..-1] + word[0..1] + 'ay'
	elsif word[0..1] == "qu" 
		w = word[2..-1]+"quay"
	elsif word[0..2] == "squ"
	 	w = word[3..-1]+"squay"
	elsif consonants.include?(word[0])
		w = word[1..-1] + word[0..0] + 'ay'
	end
	
	return w
end

text = "pig banana trash happy duck glove egg inbox eight"
puts text.split.map{ |w| pigLatin(w)}.join(' ')
text = "pig"
puts pigLatin(text)

def checkDuplicate (array)
	if array.uniq! != nil
		puts true
	else
		puts false
	end
end

def dups (array)
	return 	 array.map{ |i| break ar.count(i) > 1 ? true : false }
end
